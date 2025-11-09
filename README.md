# Inventory Pro 🚀

A comprehensive inventory management system designed for multi-store businesses to efficiently track, manage, and optimize their inventory operations.

## 📋 Project Overview

Inventory Pro is a web-based inventory management solution that helps businesses maintain optimal stock levels, manage multiple stores, track orders, and streamline supplier relationships through an intuitive and modern interface.

## ✨ Features

### 🔧 Core Functionality
- **Multi-Store Management** - Manage inventory across multiple store locations
- **Real-time Inventory Tracking** - Monitor stock levels with live updates
- **Order Management** - Create, track, and manage customer orders
- **Supplier Management** - Maintain supplier information and relationships
- **Stock Alerts** - Automatic low-stock and out-of-stock notifications
- 
### 📊 Dashboard & Analytics
- **Overview Dashboard** - Key metrics and quick insights
- **Inventory Analytics** - Stock movement and performance reports
- **Order Statistics** - Sales and order tracking
- **Store Performance** - Individual store inventory metrics

## 🏗️ System Architecture

### Frontend
- **HTML5** - Semantic markup structure
- **CSS3** - Modern styling with CSS variables and Flexbox/Grid
- **JavaScript** - Client-side interactivity
- **Bootstrap 5** - Responsive framework
- **Font Awesome** - Icon library

### Backend
- **PHP** - Server-side logic and processing
- **MySQL/PDO** - Database management with prepared statements
- **Session Management** - Secure user authentication

### Database Schema
```
📦 InventoryPro Database
├── 👥 user (userid, username, password, role, email, created_at)
├── 📦 item (itemid, itemname, description, quantity, category, unitprice, availability, criticalvalue)
├── 🏪 store (store_id, store_name, location, manager, contact, created_at)
├── 📋 orders (orderid, userid, itemid, store_id, quantity, orderdate, status)
├── 🚚 supplier (supplier_id, supplier_name, contact, email, address, item_type)
└── 🔄 supplies (supply_id, supplier_id, itemid, quantity, supply_date, status)
```

## 🚀 Installation Guide

### Prerequisites
- Web server (Apache/Nginx)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser

### Step-by-Step Installation

1. **Download and Extract**
   ```bash
   # Clone or download the project files
   # Extract to your web server directory (e.g., htdocs, www, or public_html)
   ```

2. **Database Setup**
   ```sql
   -- Create database
   CREATE DATABASE test_wad;
   
   -- Import the provided SQL schema file
   -- Or run the individual table creation scripts
   ```

3. **Configuration**
   ```php
   private $host = 'localhost';
   private $dbname = 'test_wad';
   private $username = 'your_username';
   private $password = 'your_password';
   ```
   ...
4. **Access the Application**
   ```
   Open your browser and navigate to:
   http://localhost/inventory-pro/
   ```

## 📱 Module Details

### 🏠 Dashboard Module
- Real-time inventory overview
- Quick statistics and metrics
- Recent activity feed
- Store performance indicators

### 📦 Inventory Module
- Track item availability
- Notified Critical value
- see overall details of inventory items

### 🛒 Orders Module
- Create new orders
- Order history

### 🚚 Supplier Module
- Supplier information management
- Contact management

### 🏪 Store Management
- Multi-store configuration
- Store management - CRUD

### Database Configuration
```php
class DbConnector {
    private $host = "localhost";
    private $dbname = "test_wad";
    private $username = "your_username";
    private $password = "your_password";
    
    public function getConnection() {
        // PDO connection with error handling
    }
}
```
- [ ] Multi-language support
- [ ] Cloud deployment options

---

**Inventory Pro** - Streamlining inventory management for modern businesses. 📊🛒🚀
