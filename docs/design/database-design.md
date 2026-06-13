# Database Design

The Help A Stray prototype uses a MySQL relational database consisting of three main tables: admins, animals and applications.

## Admins Table

The admins table stores administrator login credentials and provides access control for the administration area.

Primary Key:

* admin_id

Attributes:

* username
* password

## Animals Table

The animals table stores information about animals available for adoption.

Primary Key:

* animal_id

Attributes:

* name
* species
* breed
* age
* gender
* description
* image
* status
* created_at

## Applications Table

The applications table stores adoption applications submitted by users.

Primary Key:

* application_id

Foreign Key:

* animal_id

Attributes:

* full_name
* email
* phone
* address
* housing_type
* experience
* status
* application_date

## Relationships

A single animal may have multiple adoption applications.

Relationship:
Animals (1) → Applications (Many)

Referential integrity is maintained through the use of foreign key constraints.
