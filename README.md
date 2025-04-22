# CRUD_DB
# Database Setup: crud_db and people Table

This guide provides instructions on how to set up the `crud_db` database and create the `people` table using the provided SQL script. This setup is likely intended for a MySQL or MariaDB environment.

## Prerequisites

Before you begin, ensure you have the following:

1.  A MySQL or MariaDB server installed and running.
2.  Access to a MySQL/MariaDB client to execute SQL commands (e.g., `mysql` command-line tool, phpMyAdmin, MySQL Workbench, DBeaver, etc.).
3.  Appropriate user privileges to create databases and tables.

## Setup Instructions

Follow these steps to create the database and table:

### 1. Create the Database

Connect to your MySQL/MariaDB server using your preferred client and execute the following SQL command to create the `crud_db` database if it doesn't already exist:

```sql
CREATE DATABASE IF NOT EXISTS crud_db;
```
This command ensures that you won't encounter an error if the database named crud_db already exists.

### 2. Create the `people` Table
After creating the database, you need to select it as the current database for your session. Then, you can run the script to create the `people` table.

First, select the database:
```sql
USE crud_db;
```

Next, execute the following SQL script to create the people table within the crud_db database:
```sql
CREATE TABLE IF NOT EXISTS `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `marks` varchar(100) NOT NULL, -- Note: Marks are stored as text (VARCHAR). Consider INT or DECIMAL if numeric operations are needed.
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=12;
```
## Explanation of the Table Creation Script:

`CREATE TABLE IF NOT EXISTS people`: Creates the table named people only if it doesn't already exist in the crud_db database.

`id int(11) NOT NULL AUTO_INCREMENT`: Defines an integer primary key column id that automatically increments. int(11) is a display width hint, the actual range is that of a standard INT.

`name varchar(100) NOT NULL`: A required field to store names up to 100 characters.

`address varchar(255) NOT NULL`: A required field to store addresses up to 255 characters.

`marks varchar(100) NOT NULL`: A required field to store marks up to 100 characters. Important: This uses VARCHAR, meaning marks are stored as text strings, not numbers. This might affect sorting or calculations. If marks are purely numeric, consider using INT or DECIMAL data types instead.

`PRIMARY KEY(id)`: Designates the id column as the primary key.

`ENGINE=InnoDB`: Specifies the storage engine (InnoDB is standard, supports transactions, row-level locking, and foreign keys).

`DEFAULT CHARSET=latin1`: Sets the default character set for the table. For broader character support (including emojis and more languages), utf8mb4 is often recommended.

`AUTO_INCREMENT=12`: Sets the starting value for the AUTO_INCREMENT sequence to 12. The first row inserted (if the table is empty) will have id = 12.
