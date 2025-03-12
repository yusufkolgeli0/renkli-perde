-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add unique index for slug
CREATE UNIQUE INDEX idx_category_slug ON categories(slug);

-- Modify gallery table to use category_id
ALTER TABLE gallery ADD COLUMN category_id INT AFTER category;
ALTER TABLE gallery ADD FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL;