DROP TABLE IF EXISTS memos;

CREATE TABLE memos (
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    content VARCHAR(1000),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET=utf8mb4;

INSERT INTO memos(
    title,
    content
) VALUES (
    'buying memo',
    'tomato,banana'
);
