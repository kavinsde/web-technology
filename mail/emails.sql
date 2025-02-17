-- Drop the existing table if it exists
DROP TABLE IF EXISTS emails;

-- Create the table with proper index length
CREATE TABLE emails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email_address VARCHAR(191) UNIQUE,    -- Reduced from 255 to 191 for UTF8MB4
    date_added DATETIME
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;