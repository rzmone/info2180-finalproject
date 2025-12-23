

DROP TABLE IF EXISTS notes;
DROP TABLE IF EXISTS contacts;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(255) NOT NULL,
  lastname VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  role VARCHAR(50) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(50) NOT NULL,
  firstname VARCHAR(255) NOT NULL,
  lastname VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  telephone VARCHAR(50) NOT NULL,
  company VARCHAR(255) NOT NULL,
  type VARCHAR(50) NOT NULL,
  assigned_to INT NOT NULL,
  created_by INT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_contacts_assigned_to FOREIGN KEY (assigned_to) REFERENCES users(id),
  CONSTRAINT fk_contacts_created_by FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE notes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  contact_id INT NOT NULL,
  comment TEXT NOT NULL,
  created_by INT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_notes_contact FOREIGN KEY (contact_id) REFERENCES contacts(id),
  CONSTRAINT fk_notes_created_by FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Admin user required by doc:
-- email: admin@project2.com
-- password: password123 

INSERT INTO users (firstname, lastname, password, email, role)
VALUES ('Admin', 'User', '$2y$10$qX98WRziQiIxPEQzzJvnx.vuXje63ke7W17csdJxlwyomKIlBlHwG', 'admin@project2.com', 'Admin');
