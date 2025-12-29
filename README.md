# Code Vimarsh  
**Maharaja Sayajirao University of Baroda**

A complete **User Website + Admin Panel** for the **Code Vimarsh Coding Club** at MSU Baroda.  
This project demonstrates **real-world web development practices**, focusing on clean UI/UX, structured backend, and secure content management.

---

## 🔗 Live Demo

- **User Website:**  
  👉 https://codevimarsh.rf.gd/

- **Admin Panel:**  
  👉 https://codevimarsh.rf.gd/admin

---

## 📌 Project Overview

Code Vimarsh is a student-run coding and technology club at MSU Baroda.  
This website serves as:

- 🌍 **Public website** for students and visitors  
- 🔐 **Admin dashboard** to manage content dynamically  

The project is built using **HTML, CSS, PHP, and MySQL**, without any heavy frameworks, keeping the code clean and easy to understand.

---

## 🛠️ Tech Stack

### Frontend
- HTML5  
- CSS3 (Custom, responsive, premium UI)  
- JavaScript (Vanilla)

### Backend
- PHP (Procedural, clean & readable)
- MySQL (Relational Database)

### Tools
- XAMPP (Apache + MySQL)
- phpMyAdmin
- GitHub


---

## 🌍 User Side Features

### 🏠 Home / About Section
- Club introduction (heading & description)
- “Join the Community” button
- Content managed dynamically from admin panel

### 📅 Events
- Displays upcoming events in card layout
- Each event shows:
  - Image
  - Title
  - Date & time
- Clicking an event opens a **detailed event page**
- Equal-height cards for consistent UI

### 👥 Meet the Team
- Team members grouped by categories
- Member card includes:
  - Photo
  - Name
  - Role
- Clicking a card opens the member’s **LinkedIn profile**

### 📩 Footer & Contact
- Code Vimarsh logo & MSU logo
- Social media links (WhatsApp, Instagram, LinkedIn, GitHub)
- “Chat with us” email link
- Fully dynamic & admin-controlled

---

## 🔐 Admin Panel Features

### 🔑 Authentication
- Secure admin login
- Password hashing using `password_hash()` & `password_verify()`
- Session-based authentication
- Route protection using `auth.php`

### 📊 Dashboard
Admin can manage:
- About Us section
- Events
- Team members
- Contact details & social links

### 📝 Content Management

#### About Section
- Edit heading
- Edit description
- Update “Join Community” link

#### Events
- Add new events with:
  - Title
  - Image
  - Date & time
  - Detailed description
- Edit & delete existing events

#### Team Members
- Add members with:
  - Name
  - Role
  - Category (manual input)
  - Image
  - LinkedIn URL
- Category-based display on user side

#### Contact & Social Links
- Update contact email
- Add/edit/delete social media links dynamically

---

## 🔒 Security Practices

- Prepared SQL statements (SQL injection prevention)
- Password hashing
- Session-based authentication
- Input validation & sanitization
- No hard-coded deployment paths

---

## 🚀 How to Run This Project Locally

### 1️⃣ Install XAMPP
Download from:  
👉 https://www.apachefriends.org/

---

### 2️⃣ Start Servers
Open XAMPP Control Panel and start:
- Apache
- MySQL

---

### 3️⃣ Copy Project Files
- Go to:
C:\xampp\htdocs\

- Paste the project folder
- Rename it to:
code-vimarsh

---

### 4️⃣ Import Database
1. Open browser and visit:
http://localhost/phpmyadmin
2. Create a database named:
code_vimarsh
3. Click **Import**
4. Select:
sql/code_vimarsh.sql
5. Click **Go**

---

### 5️⃣ Run the Project

- **User Side:**  
👉 http://localhost/code-vimarsh

- **Admin Panel:**  
👉 http://localhost/code-vimarsh/admin

---

## 🔑 Default Admin Credentials

Email: admin@codevimarsh.com
Password: Admin@123

---

## 🎨 UI / UX Highlights

- Premium dark theme
- Brand-consistent color palette
- Smooth scrolling navigation
- Active navigation highlight on scroll
- Fully responsive design
- Clean typography and spacing

---

## 📈 Why This Project is Valuable

- Real-world club website use case
- Clear separation of user & admin logic
- Secure backend implementation
- Easy to understand and extend
- Deployment-ready structure

---

## 👨‍💻 Author

**Ashish Gokani**  
B.Tech CSE Student, MSU Baroda  
Interested in Web Development & System Design

---

⭐ If you like this project, don’t forget to **star the repository**!
