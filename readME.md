# Grants Database (grants_db)

This repository contains the MySQL database schema for managing **grant receipts, expenditures, and allocations**.  
It is designed to support transparent tracking of incoming funds, spending, and allocation-wise budgeting.

---

## 📦 Database Overview

**Database Name:** `grants_db`  
**Database Engine:** MySQL  

The schema consists of the following core entities:

- Receipts (incoming grant funds)
- Expenditures (outgoing expenses)
- Allocations (sanctioned allocations)
- Allocation Amounts (category-wise allocation breakup)

---

## 🗄️ Database Schema

### 1. `receipts`
Stores all incoming grant receipts.

| Column | Type | Description |
|------|------|------------|
| id | INT (PK) | Auto-increment primary key |
| date | DATE | Receipt date |
| sanction_order | VARCHAR(50) | Sanction order reference |
| category | VARCHAR(255) | Grant category |
| amount | DECIMAL(12,2) | Amount received |
| attachment | TEXT | File path or URL for documents |
| created_at | TIMESTAMP | Record creation timestamp |

---

### 2. `expenditures`
Tracks all outgoing expenses.

| Column | Type | Description |
|------|------|------------|
| id | INT (PK) | Auto-increment primary key |
| date | DATE | Expense date |
| bill_no | VARCHAR(50) | Bill number |
| voucher_no | VARCHAR(50) | Voucher number |
| category | VARCHAR(255) | Expense category |
| sub_category | VARCHAR(255) | Expense sub-category |
| department | VARCHAR(255) | Department name |
| amount | DECIMAL(12,2) | Expense amount |
| attachment | TEXT | Supporting document |
| created_at | TIMESTAMP | Record creation timestamp |

---

### 3. `allocations`
Represents sanctioned allocations.

| Column | Type | Description |
|------|------|------------|
| id | INT (PK) | Auto-increment primary key |
| date | DATE | Allocation date |
| allocation_number | VARCHAR(50) | Allocation reference number |
| created_at | TIMESTAMP | Record creation timestamp |

---

### 4. `allocation_amounts`
Stores category-wise allocation amounts linked to an allocation.

| Column | Type | Description |
|------|------|------------|
| id | INT (PK) | Auto-increment primary key |
| allocation_id | INT (FK) | References `allocations(id)` |
| category | VARCHAR(255) | Allocation category |
| allocated_amount | DECIMAL(12,2) | Allocated amount |

**Relationships**
- `allocation_amounts.allocation_id` → `allocations.id`
- Cascade delete enabled to maintain referential integrity

---