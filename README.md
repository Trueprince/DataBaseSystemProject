SPU Students Residence Allocation & Management System

Welcome to the GitHub repository for the Sol Plaatje University (SPU) Students Residence Allocation & Management System project. This project aims to develop a robust and user-friendly, web-based, database-driven system that streamlines residence application, room allocation, and management processes at SPU.

Project Overview
Background
The SPU administration approached our team to design a system that simplifies and automates the process of residence allocation and management for students. To ensure we thoroughly understand their needs and requirements, we conducted a series of meetings and workshops with key stakeholders, including students and residence managers.

Objectives

Simplify the residence application process: Students should be able to easily apply for residence accommodation online.
Efficient room allocation: The residence manager should have an intuitive interface to manage room allocations, keep track of occupancy, and manage residence data efficiently.
User-friendly experience: The system should be intuitive, accessible, and easy to navigate for all users.
Features

For Students:
Online Residence Application: Apply for residence accommodation, view application status, and receive notifications about room allocations.
Profile Management: Manage and update personal details.
For Residence Managers:
Room Allocation: Efficiently allocate rooms to students and manage room availability.
Student Management: View and manage student applications, track room assignments, and generate reports.
Dashboard: An overview of available rooms, student application status, and key statistics.
Database Design
Participating Entities and Their Attributes
Students:

StudentID (Primary Key)
FirstName
LastName
DateOfBirth
Gender
Email
PhoneNumber
ProgramOfStudy
YearOfStudy
Residence:

ResidenceID (Primary Key)
ResidenceName
Location
TotalRooms
RoomsAvailable
Room:

RoomID (Primary Key)
ResidenceID (Foreign Key)
RoomNumber
RoomType (e.g., single, double)
IsOccupied
Applications:

ApplicationID (Primary Key)
StudentID (Foreign Key)
ResidenceID (Foreign Key)
ApplicationDate
Status (e.g., pending, approved, declined)
RoomID (Foreign Key, nullable until allocated)

Relationships

Students apply for residence, forming a relationship between Students and Applications.
Applications link students to a Residence and a Room upon approval.
Rooms are part of a Residence, establishing a one-to-many relationship between Residence and Room.
Entity-Relationship Diagram (ERD)
The ERD will illustrate the relationships between these entities, showcasing the primary and foreign keys that connect them.

System Design and Development
Our team followed a creative and user-centered design approach to ensure the system meets the needs of both students and residence managers. Here are the key steps in our development process:

Requirements Gathering: Through meetings and interviews with SPU stakeholders, we gathered detailed information about the desired system features and workflows.
Database Design: We modeled the system using an ERD, defining the relationships between various entities and ensuring data integrity.
System Development: We implemented the system using modern web development frameworks, ensuring a responsive and intuitive user interface.
Testing and Quality Assurance: We rigorously tested the system to ensure reliability and a smooth user experience.
Presentation Preparation: We prepared a comprehensive presentation to demonstrate the features, design choices, and final product.
