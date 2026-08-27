<div align="center">
  <img src="https://github.com/Nell-JvR-251061/polyplex/blob/main/assets/githubBanner.png" alt="Banner">
</div>

# About
PolyPlex was conceptualized from the following limitations: no images, everything must be for trade and all content only lasts a week!\
This lead me to creating polyplex as a geometry based, trading-auto-battler in which user's will receive a weekly team of three shapes; trade these shapes for others and battle with their team against other users.

## Built With
[![PHP](https://img.shields.io/badge/php-%23777BB4.svg?&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=fff)](https://www.mysql.com/)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=000)](https://www.javascript.com/)
[![HTML](https://img.shields.io/badge/HTML-%23E34F26.svg?logo=html5&logoColor=white)](https://www.w3schools.com/html/)
[![CSS](https://img.shields.io/badge/CSS-639?logo=css&logoColor=fff)](https://www.w3schools.com/css/)

# Features
- Shape-based visuals achieved by using SVG tags.
- User login/signup.
  - User personal dashboard.
  - Password hashing.
- Battle system.
- Trading functionality.
- Database centered flow.
  - created multiple tables using primary and foreign keys.
  - stores users, shapes, matches, trading and shape abilities information.
- Weekly renewal of all shapes and trading posts.

# Development
Additional documentation can be found under the design folder:
```
polyplex/assets/design
```
## Entity–Relationship Diagram (ERD)
<div align="center">
  <img src="https://github.com/Nell-JvR-251061/polyplex/blob/main/assets/erd.png" alt="ER Diagram">
</div>

## Wireframes
<table>
  <tr>
    <td><img src="https://github.com/Nell-JvR-251061/polyplex/blob/main/assets/wireframes/homepage.png" width="100%"></td>
    <td><img src="https://github.com/Nell-JvR-251061/polyplex/blob/main/assets/wireframes/battlePage.png" width="100%"></td>
  </tr>
  <tr>
    <td><img src="https://github.com/Nell-JvR-251061/polyplex/blob/main/assets/wireframes/login.png" width="100%"></td>
    <td><img src="https://github.com/Nell-JvR-251061/polyplex/blob/main/assets/wireframes/dashboard.png" width="100%"></td>
  </tr>
  <tr>
    <td><img src="https://github.com/Nell-JvR-251061/polyplex/blob/main/assets/wireframes/sign-up.png" width="100%"></td>
    <td><img src="https://github.com/Nell-JvR-251061/polyplex/blob/main/assets/wireframes/tradingPost.png" width="100%"></td>
  </tr>
</table>

## Development Process & Challenges
Using HTML, CSS and PHP with a touch of JavaScript felt very nostalgic compared to the days of web development. I needed to take a step from the React-based approach of plug-in-based rapid development and take more care in creating my pages, components and functions from the ground up.

### Database Creation
Learning SQL was initially quite daunting as the strict rules and restrictions around database construction felt very limiting. However after wrestling with it for a while primary and foreign keys started to make sense. I began to understand how these relationships could be used to create an structured database.

This allowed me to build relationships between parts of Polyplex such as users, their game data, battles and trades. Of storing everything in one large table I could separate the information into logical sections and use relationships to connect them. This made the database organized and reduced unnecessary duplication of information.

### PHP Integration
Integrating PHP into the project was another learning experience. Coming from a React-focused development approach I was used to components and client-side state management handling much of the application logic. PHP required me to think about how pages were generated and how information moved between the browser, server and database.

PHP became the bridge between the frontend and the database. Of simply displaying static HTML I could retrieve information from MySQL process it on the server and then dynamically generate the appropriate content for the user.

## Mockups
<div align="center">
  <img src="https://github.com/Nell-JvR-251061/polyplex/blob/main/assets/mockupA.png" alt="Mockup A">
  <img src="https://github.com/Nell-JvR-251061/polyplex/blob/main/assets/mockupB.png" alt="Mockup B">
</div>

# Installation
Follow the steps below to install and run PolyPlex on a locally.

### Requirements
Before starting, you will need:
- XAMPP (For running the database and server locally)
  - Apache (automatically comes with XAMPP)
  - MySQL (automatically comes with XAMPP)
- Web browser

## 1. Install XAMPP

Download XAMPP from the official Apache Friends website:

https://www.apachefriends.org/download.html

Run the XAMPP installer.

During installation, make sure the following components are selected:

- Apache
- MySQL
- PHP
- phpMyAdmin

The default installation location is recommended:

```
C:\xampp
```

## 2. Download the PolyPlex Project

You can download the PolyPlex project directly from GitHub as a ZIP file.

### Download the ZIP

Go to the PolyPlex GitHub repository:

https://github.com/Nell-JvR-251061/polyplex

On the GitHub page:

1. Click the green **Code** button.
2. Click **Download ZIP**.
3. Wait for the ZIP file to finish downloading.

The downloaded file will usually be named something similar to:

```
polyplex-main.zip
```

###Extract the ZIP File

Navigate to your Downloads folder.

Right-click the downloaded ZIP file and select:
```
Extract All...
```

Extract the project into:
```
C:\xampp\htdocs\polyplex-main
```

###Rename the Folder

Rename:
```
polyplex-main  -- to -->  polyplex
```

Your project structure should look like this:
```
C:\xampp\htdocs\
│
└── polyplex\
    ├── assets\
    ├── components\
    ├── config\
    ├── database\
    ├── pages\
    ├── styling\
    ├── index.php
    └── README.md
```

## 3. Start Apache and MySQL
In the XAMPP Control Panel, locate:
```
Apache
MySQL
```
Click Start next to both services.\
The services should now appear as running, indicated by Start turning into Stop.

Apache is responsible for running the PHP application and MySQL for storing the PolyPlex database.

## 4. Create the Database
### Open phpMyAdmin

With Apache and MySQL running in XAMPP:

Open your web browser and navigate to: http://localhost/phpmyadmin/ \
phpMyAdmin should open and display your local MySQL databases.

### Create the Polyplex Database

Create a new database for the project.

Select New from the left-hand sidebar.
Enter the database name:
polyplex
Use the default collation unless the project specifies another one.
Click Create.

You should now see polyplex listed in the database sidebar.

### Import the Database Structure

The repository contains the SQL database export:
```
database/polyplex.sql
```

To import it:

Select the newly created polyplex database in phpMyAdmin. \
Click the Import tab. \
Click Choose File. \
Select:
```
polyplex/database/polyplex.sql
```
Leave the import settings at their defaults unless the SQL file requires otherwise. \

Click Import or Go. /
If the import is successful, phpMyAdmin should display a confirmation message and the database should contain the tables required by Polyplex.

## 5. Configure the Application

After creating the database, the PHP application needs to know how to connect to your local MySQL server.

### Locate the Configuration Files

Open the project's:
```
config/
```
directory.

Look for the PHP file responsible for establishing the database connection. Depending on the implementation, this may contain variables or a connection object for values such as:
```
Host
Username
Password
Database name
```
The exact configuration should match the database created in Step 4.

### Configure the Database Connection

For a standard XAMPP installation, the local MySQL configuration commonly uses:
```
Host: localhost
Username: root
Password: 
Database: polyplex
```
For example, a PHP database configuration may conceptually look like:
```
$host = "localhost";
$username = "root";
$password = "";
$database = "polyplex";
```
Check how the project's configuration file is structured and update the existing values rather than creating a second database connection.

If your MySQL installation has a password configured for the root user, use that password instead of leaving the password empty.

### Check the Database Host and Port

If the application cannot connect to MySQL, check the MySQL settings in XAMPP.

The default MySQL port is commonly:
```
3306
```
If your MySQL server is configured to use another port, the application's database connection must use that port.

For example:
```
localhost:3306
```
may need to be changed to the port configured by your XAMPP installation.

### Check PHP Configuration Files

Before running the application, make sure the PHP configuration files do not contain references to a remote database or another developer's environment.

Check for values such as:
```
localhost
127.0.0.1
root
polyplex
```
and verify that they correspond to your local environment.

Also make sure that any required configuration files are actually present after cloning the repository.

## 6. Launch and Test Polyplex

Once the project files, Apache server, MySQL server, and database have all been configured, the application can be launched.

### Start XAMPP Services

Open the XAMPP Control Panel.

Make sure the following services are running:
```
Apache    Running
MySQL     Running
```

### Finally Open a Browser and Navigate to: http://localhost/polyplex/

## Demonstration
[PolyPlex Demo](https://drive.google.com/drive/u/3/folders/1wM7uSDNI_DfUhJdKLAUws4u9Z7kHwBdp)
