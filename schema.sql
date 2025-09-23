-- ===== RESET & USE DB =====
DROP DATABASE IF EXISTS rest_assured;
CREATE DATABASE IF NOT EXISTS rest_assured
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE rest_assured;

-- ===== OWNERS =====
CREATE TABLE owners (
  id            INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(150) NOT NULL,
  contact       VARCHAR(50)  NULL,
  email         VARCHAR(120) NULL,
  address       VARCHAR(255) NULL,
  purchase_date DATE         NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uk_owners_name_email (name, email)
) ENGINE=InnoDB;

-- ===== PLOTS =====
CREATE TABLE plots (
  plot_code          VARCHAR(50)  NOT NULL PRIMARY KEY,
  section            VARCHAR(10)  NULL,
  lot                VARCHAR(20)  NULL,
  grave              VARCHAR(20)  NULL,
  status             ENUM('available','occupied','reserved') NOT NULL DEFAULT 'available',
  reserved_for       VARCHAR(150) NULL,
  reservation_expiry DATE         NULL,
  notes              TEXT         NULL,
  owner_id           INT          NULL,
  created_at         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_plots_owner
    FOREIGN KEY (owner_id) REFERENCES owners(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE INDEX idx_plots_status ON plots(status);

-- ===== BURIALS (deceased) =====
CREATE TABLE burials (
  id            INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  plot_code     VARCHAR(50)  NOT NULL,
  deceased_name VARCHAR(150) NOT NULL,
  birth_date    DATE NULL,
  death_date    DATE NULL,
  burial_date   DATE NULL,
  unique_code   VARCHAR(50)  NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_burials_plot
    FOREIGN KEY (plot_code) REFERENCES plots(plot_code)
    ON UPDATE CASCADE ON DELETE CASCADE,
  UNIQUE KEY uk_burials_unique_code (unique_code),
  INDEX idx_burials_plot (plot_code)
) ENGINE=InnoDB;

-- ===== PAYMENTS =====
CREATE TABLE payments (
  id               INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  plot_code        VARCHAR(50) NOT NULL,
  status           ENUM('paid','pending','overdue') NOT NULL DEFAULT 'pending',
  amount_paid      DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  next_payment_due DATE NULL,
  plan             ENUM('full','monthly','quarterly','annual','annually') NOT NULL DEFAULT 'full',
  created_at       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_payments_plot
    FOREIGN KEY (plot_code) REFERENCES plots(plot_code)
    ON UPDATE CASCADE ON DELETE CASCADE,
  INDEX idx_pay_plot (plot_code)
) ENGINE=InnoDB;

-- ===== CUSTOMERS =====
CREATE TABLE customers (
  id        INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name      VARCHAR(150) NOT NULL,
  email     VARCHAR(120) NULL,
  phone     VARCHAR(50)  NULL,
  address   VARCHAR(255) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uk_customers_name_email (name, email)
) ENGINE=InnoDB;

-- ===== TRANSACTIONS =====
CREATE TABLE transactions (
  id            INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  txn_id        VARCHAR(36) NOT NULL UNIQUE,
  customer_id   INT NULL,
  customer_name VARCHAR(150) NULL,
  deceased_name VARCHAR(150) NULL,
  plot_code     VARCHAR(50)  NULL,
  service_type  ENUM('renewal','maintenance','service_fee','transfer','burial') NOT NULL,
  amount        DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  method        ENUM('gcash','bank_transfer','cash','credit_card','debit_card') NOT NULL,
  method_type   ENUM('online','offline','installment') NOT NULL,
  payment_date  DATE NOT NULL,
  status        ENUM('paid','pending','overdue') NOT NULL DEFAULT 'paid',
  receipt_path  VARCHAR(255) NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_txn_customer
    FOREIGN KEY (customer_id) REFERENCES customers(id)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_txn_plot
    FOREIGN KEY (plot_code) REFERENCES plots(plot_code)
    ON UPDATE CASCADE ON DELETE SET NULL,
  INDEX idx_txn_date (payment_date),
  INDEX idx_txn_service (service_type)
) ENGINE=InnoDB;

-- ===== EMAIL TEMPLATES =====
CREATE TABLE email_templates (
  code        VARCHAR(50) PRIMARY KEY,
  name        VARCHAR(100) NOT NULL,
  subject     VARCHAR(255) NOT NULL,
  body        TEXT NOT NULL,
  is_active   TINYINT(1) NOT NULL DEFAULT 1,
  created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===== NOTIFICATION RULES =====
CREATE TABLE notification_rules (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  rule_type     ENUM('RENEWAL','BIRTHDAY','DEATH_ANNIV','BURIAL_ANNIV','ALL_SOULS') NOT NULL,
  template_code VARCHAR(50) NOT NULL,
  days_before   INT NOT NULL DEFAULT 7,   -- for ALL_SOULS: before Nov 2
  is_active     TINYINT(1) NOT NULL DEFAULT 1,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_rule_template
    FOREIGN KEY (template_code) REFERENCES email_templates(code)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX idx_rule_type (rule_type)
) ENGINE=InnoDB;

-- ===== NOTIFICATION QUEUE (with generated column for UNIQUE) =====
CREATE TABLE notification_queue (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  rule_type        ENUM('RENEWAL','BIRTHDAY','DEATH_ANNIV','BURIAL_ANNIV','ALL_SOULS') NOT NULL,
  template_code    VARCHAR(50) NOT NULL,
  recipient_name   VARCHAR(150) NOT NULL,
  recipient_email  VARCHAR(150) NOT NULL,
  plot_code        VARCHAR(50)  NULL,
  deceased_name    VARCHAR(150) NULL,
  event_date       DATE NULL,         -- date we are reminding about (e.g., birthday)
  send_on          DATETIME NOT NULL, -- when to send
  sent_on_date     DATE AS (DATE(send_on)) STORED,  -- <- generated date part
  status           ENUM('queued','sent','failed') NOT NULL DEFAULT 'queued',
  sent_at          DATETIME NULL,
  error_msg        VARCHAR(255) NULL,
  payload_json     JSON NULL,
  created_at       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_queue_template
    FOREIGN KEY (template_code) REFERENCES email_templates(code)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_queue_plot
    FOREIGN KEY (plot_code) REFERENCES plots(plot_code)
    ON UPDATE CASCADE ON DELETE SET NULL,
  UNIQUE KEY uk_queue_once (rule_type, recipient_email, plot_code, event_date, sent_on_date)
) ENGINE=InnoDB;

-- ===== SEED: TEMPLATES =====
INSERT INTO email_templates (code, name, subject, body) VALUES
('TPL_RENEWAL',
 'Renewal Reminder',
 'Renewal Reminder for Plot {{plot_code}}',
 'Hi {{owner_name}},\n\nThis is a friendly reminder that the renewal for plot {{plot_code}} is due on {{event_date}}.\n\nIf already paid, kindly ignore this message.\n\nThank you,\nRest Assured'),
('TPL_BIRTHDAY',
 'Birthday Remembrance',
 'Remembering {{deceased_name}} on their birthday ({{event_date}})',
 'Dear {{owner_name}},\n\nWe remember {{deceased_name}} on their birthday ({{event_date}}). Our thoughts are with you.\n\n— Rest Assured'),
('TPL_DEATH_ANNIV',
 'Death Anniversary',
 'In memory of {{deceased_name}} ({{event_date}})',
 'Dear {{owner_name}},\n\nWe honor the memory of {{deceased_name}} on their death anniversary ({{event_date}}).\n\n— Rest Assured'),
('TPL_BURIAL_ANNIV',
 'Burial Anniversary',
 'Remembering {{deceased_name}} on {{event_date}}',
 'Dear {{owner_name}},\n\nWe remember {{deceased_name}} on their burial anniversary ({{event_date}}).\n\n— Rest Assured'),
('TPL_ALL_SOULS',
 'All Souls’ Day',
 'All Souls’ Day (Nov 2) — Remembrance',
 'Dear {{owner_name}},\n\nAs All Souls’ Day approaches, we keep the faithful departed, including {{deceased_name}}, in our prayers.\n\n— Rest Assured');

-- ===== SEED: RULES =====
INSERT INTO notification_rules (rule_type, template_code, days_before) VALUES
('RENEWAL',     'TPL_RENEWAL',      30),
('BIRTHDAY',    'TPL_BIRTHDAY',      7),
('DEATH_ANNIV', 'TPL_DEATH_ANNIV',   7),
('BURIAL_ANNIV','TPL_BURIAL_ANNIV',  7),
('ALL_SOULS',   'TPL_ALL_SOULS',     7);

-- ===== SAMPLE DATA (ties to burial plot & manage records) =====
INSERT INTO owners (name, contact, email, address, purchase_date) VALUES
('Juan Dela Cruz','09171234567','juan@example.com','Quezon City', '2024-03-10'),
('Maria Clara','09179876543','maria@example.com','Cebu City',   '2024-04-02');

INSERT INTO plots (plot_code, section, lot, grave, status, owner_id)
VALUES
('A/101/1','A','101','1','occupied', (SELECT id FROM owners WHERE name='Juan Dela Cruz' LIMIT 1)),
('A/101/2','A','101','2','available', NULL);

INSERT INTO burials (plot_code, deceased_name, birth_date, death_date, burial_date, unique_code)
VALUES
('A/101/1','Lola Rosa','1950-06-15','2024-05-15','2024-05-20','D20240520R1')
ON DUPLICATE KEY UPDATE deceased_name = VALUES(deceased_name);

INSERT INTO payments (plot_code, status, amount_paid, next_payment_due, plan)
VALUES ('A/101/1','paid',15000,'2025-05-20','annual')
ON DUPLICATE KEY UPDATE
  status = VALUES(status),
  amount_paid = VALUES(amount_paid),
  next_payment_due = VALUES(next_payment_due),
  plan = VALUES(plan);

INSERT INTO customers (name, email, phone, address) VALUES
('Juan Dela Cruz','juan@example.com','09171234567','Quezon City'),
('Maria Clara','maria@example.com','09179876543','Cebu City');

INSERT INTO transactions
  (txn_id, customer_id, customer_name, deceased_name, plot_code, service_type, amount, method, method_type, payment_date, status, receipt_path)
VALUES
  ('TXN-0001-A1011',
   (SELECT id FROM customers WHERE name='Juan Dela Cruz' LIMIT 1),
   'Juan Dela Cruz',
   'Lola Rosa',
   'A/101/1',
   'renewal',
   15000.00,
   'gcash',
   'online',
   '2024-05-20',
   'paid',
   NULL);
