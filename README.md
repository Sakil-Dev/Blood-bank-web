# 🩸 Blood Bank Management System

A professional, web-based management system designed to coordinate blood donations, manage inventory, and handle hospital requests efficiently. This system uses a real-time stock update mechanism to ensure life-saving blood units are tracked accurately.

---

## 🚀 Key Features

* **Role-Based Access**: Specialized dashboards for **Admin**, **Donor**, and **Hospital** roles.
* **Live Inventory Tracking**: Real-time monitoring of stock levels for all 8 blood groups ($A\pm, B\pm, O\pm, AB\pm$) in milliliters (ml).
* **Automated Stock Sync**:
    * **Donations**: Automatically increases inventory when a donor gives blood.
    * **Requests**: Deducts from stock upon administrative approval.
* **Request Management**: Streamlined workflow to approve or reject blood requests from patients and hospitals.
* **Donor History**: Complete logs of every donor's medical info and donation frequency.
* **Secure Authentication**: Session-based login with password protection and role verification.

---

## 🛠️ Technical Stack

* **Backend**: PHP 8.x (Procedural & Logic-driven)
* **Database**: MySQL / MariaDB
* **Frontend**: HTML5, CSS3 (Custom Theme), FontAwesome 6.4.2
* **Server**: Optimized for Apache (XAMPP / WAMP / Linux)

---

## 📊 Database Architecture

The application is powered by a relational database named `blood bank`. Below are the primary tables:

| Table Name | Description |
| :--- | :--- |
| `users` | Stores login credentials and role assignments (Admin/Donor/Hospital). |
| `donors` | Contains detailed profiles including blood group and contact info. |
| `blood_stock` | The central ledger for current blood volume (ml) per group. |
| `blood_requests`| Tracks incoming requests, volume needed, and fulfillment status. |
| `donations` | Logs historical data of every successful donation event. |

---

## ⚙️ Installation & Setup

1.  **Clone the Project**:
    ```bash
    git clone [([(https://github.com/Sakil-Dev/Blood-bank-web.git)][(https://github.com/Sakil-Dev/Blood-bank-web.git)}
    ```

2.  **Database Configuration**:
    * Open **phpMyAdmin**.
    * Create a new database named `blood bank`.
    * Import the `blood_bank(1).sql` file found in the root directory.

3.  **Connection Setup**:
    * Open `db_connect.php` and verify your local server settings:
    ```php
    $conn = mysqli_connect("localhost", "root", "your_password", "blood bank");
    ```

4.  **Run the Application**:
    * Move the project folder to your server's root (e.g., `htdocs`).
    * Open your browser and go to `http://localhost/blood-bank-management/index.php`.

---

## 🎨 UI/UX Design

The system features a custom **Cyan & Crimson** color palette designed for high visibility and professional medical aesthetics. It includes:
* Interactive progress bars for blood stock.
* Status badges (Pending, Approved, Rejected) for easy tracking.
* Responsive sidebar navigation for seamless multitasking.

---

## 📄 License
Distributed under the **MIT License**. See `LICENSE` for more information.

---

**Developed with ❤️ to save lives.** *If you find this project useful, please consider giving it a ⭐!*

5. **Screen Shoot**:
 1.Login Page
 <img width="1910" height="902" alt="login" src="https://github.com/user-attachments/assets/a779b279-1657-4a56-8a5b-db79fc2aa224" />
 
 2.Registration Page
 <img width="1911" height="900" alt="Register" src="https://github.com/user-attachments/assets/34c274bb-a3a1-4f85-beea-fefdaace9602" />
 
 3.Dashboard Page
 <img width="1919" height="907" alt="dashboard" src="https://github.com/user-attachments/assets/ac2b8b38-4dc1-4be8-8028-72cd327ccb30" />

 4.Donor
 <img width="1912" height="903" alt="donor" src="https://github.com/user-attachments/assets/4fe8a88a-c69e-4296-a782-2f2d6805a569" />

 5.List od donations
 <img width="1917" height="894" alt="donation records" src="https://github.com/user-attachments/assets/e0bd26fb-ce5d-4d22-890b-5f429938c6b8" />

 6.Blood Request
 <img width="1919" height="907" alt="blood request" src="https://github.com/user-attachments/assets/b4d450f8-1c28-4491-a9ad-b9458e6e15f1" />

 7.Request History
 <img width="1919" height="904" alt="request history" src="https://github.com/user-attachments/assets/6cf70480-92dd-454d-81f1-97d17c3c3f47" />

  8.Blood Stock
  <img width="1915" height="914" alt="6" src="https://github.com/user-attachments/assets/a67298c9-86bd-406a-bdd1-d8dd8a9c694f" />
