# Support Ticket System

🎫 Laravel Ticketing System API

A RESTful Ticket Management System built with Laravel.
This project implements a complete ticket workflow with roles, authorization policies, file attachments, and clean architecture.

🚀 Features

✅ Authentication (Laravel built-in auth / Sanctum ready)

✅ Role-based access control (User, Support, Admin)

✅ Ticket CRUD operations

✅ Ticket assignment (Support/Admin)

✅ File attachments for tickets

✅ Authorization using Policies

✅ Clean RESTful API structure

✅ Proper database relationships

✅ Cascade delete for attachments

✅ Secure access control

👥 Roles
🧑 User

Create tickets

View own tickets

Cannot update or delete tickets

🛠 Support

View all tickets

Update tickets

Assign tickets

👑 Admin

Full access

Delete tickets

Assign tickets

Manage all records

🏗 Database Structure
tickets

id

user_id (FK)

title

description

status

assigned_to (nullable)

timestamps

ticket_attachments

id

ticket_id (FK)

file_path

timestamps

Attachments are deleted automatically when a ticket is deleted (cascade).

🔐 Authorization

Implemented using Laravel Policies:

viewAny   → Support, Admin  
view      → Owner, Support, Admin  
create    → User  
update    → Support, Admin  
delete    → Admin  
assign    → Support, Admin  

📂 Installation
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name

composer install
cp .env.example .env
php artisan key:generate


Configure database inside .env, then:

php artisan migrate
php artisan serve

📎 File Upload

Ticket attachments are stored using Laravel storage system.

Make sure to run:

php artisan storage:link

🛠 Tech Stack

Laravel

MySQL

Eloquent ORM

RESTful API

Policy Authorization

File Storage System

📌 API Example Endpoints
GET     /api/tickets
POST    /api/tickets
GET     /api/tickets/{id}
PUT     /api/tickets/{id}
DELETE  /api/tickets/{id}
POST    /api/tickets/{id}/assign
POST    /api/tickets/{id}/attachments

💡 What This Project Demonstrates

Clean backend architecture

Role-based permission handling

Real-world ticket workflow logic

Proper database design

Secure API development

👨‍💻 Author

Kamran Rezaei
Backend Developer (Laravel, Django, FastAPI)
GitHub: https://github.com/Kamran3515