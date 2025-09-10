# 🩺 Depression Support Medical System  

A web-based medical system designed to support patients who may be experiencing depression.  
The platform enables patients, counselors, doctors, and managers to interact through a secure and user-friendly system.  
This project was originally developed in 2023 using HTML, PHP, CSS, JavaScript, and MySQL and later uploaded to GitHub in 2025 for portfolio purposes.

---

## 📌 Overview  
This project was developed as part of a software engineering course project.  
Its objective is to design a platform where:  
- Patients can register, take a self-assessment test, and get medical help.  
- Counselors and doctors can review results, manage patient records, and set appointments.  
- Managers can oversee system activity, assign patients, and generate reports.  

The system followed an **Agile development approach** with iterative sprints and focuses on building a **middle-fidelity prototype** that can serve as the basis for a real product.  

---

## 👥 User Roles & Capabilities  

### **Patient**  
- Register with personal details  
- Take or cancel a **self-assessment test (PHQ-9)**  
- View appointments with counselors or doctors  
- Accept or reject appointments  

### **Counselor**  
- Register with counselor details  
- View list of patients and their self-assessment results  
- Schedule or manage appointments  
- Assign patients to doctors or reject patients  

### **Doctor**  
- Register with doctor details  
- View assigned patient list and self-assessment results  
- Schedule, modify, or reject appointments  

### **Manager**  
- Approve or reject doctors and counselors  
- Add or remove patients  
- Assign patients after self-assessment  
- Generate reports (daily, weekly, monthly) on patient registrations and assignments  

---

## ⚙️ Features  
- 📝 Patient registration & secure login  
- 📊 Depression self-assessment using **PHQ-9** questionnaire  
- 📅 Appointment scheduling and management  
- 🔄 Patient assignment and referral system (Counselor ↔ Doctor)  
- 📑 Reports on patient activity and assignments  
- 🔒 Data security, privacy, and informed consent compliance  

---

## 🛠️ Tech Stack (Prototype)  
- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP (or chosen framework during prototyping)  
- **Database:** MySQL  
- **Tools & Process:** Agile (Scrum-like), Jira/Asana for progress tracking  

---

## 🚀 How to Run  
1. Clone this repository  
2. Import the provided SQL schema into MySQL  
3. Run the project using XAMPP/LAMP/WAMP  
4. Access it via `http://localhost/spm`  

---

## 📖 Notes  
- This project was developed in an academic setting as part of **SOEN 6841 (Winter 2023)**.  
- The prototype demonstrates the workflow of a medical system but is **not production-ready**.  
- Future improvements could include:  
  - Migrating to a modern backend  
  - Implementing role-based authentication with JWT/OAuth2  
  - Enhanced analytics and dashboards  

---

## 📚 References  
- Course: **SOEN 6841 – Software Engineering Team Project** (Winter 2023)
- [PHQ-9 Questionnaire (CAMH)](https://tools.camh.ca/phq9/#:~:text=Patient%20Health%20Questionnaire%20(PHQ-9)%20-%20CAMH)

---
