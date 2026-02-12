ALTER TABLE poles ADD COLUMN coordinator_user_id INT UNSIGNED NULL AFTER address;
ALTER TABLE poles ADD CONSTRAINT fk_poles_coordinator FOREIGN KEY (coordinator_user_id) REFERENCES users(id) ON DELETE SET NULL;
