# Evaluation

## Overview

The Help A Stray prototype was evaluated against the functional, non-functional and security requirements identified during the requirements analysis stage. The evaluation considered usability, functionality, database design, security measures and overall system performance.

## Functional Requirements Evaluation

The prototype successfully implemented all core functional requirements. Users can browse available animals, search by name, filter animal listings, view detailed animal profiles and submit adoption applications. Administrators can log into a secure administration area, manage animal profiles and review adoption applications.

The animal management functionality supports adding, editing and deleting animal records. Adoption applications can be reviewed and their status updated to Pending, Approved or Rejected.

## Non-Functional Requirements Evaluation

The application provides a clear and responsive user interface that can be accessed through a web browser. Shared layouts, reusable navigation components and consistent styling improve usability.

The MySQL relational database provides efficient storage and retrieval of animal and application data. The system architecture separates presentation, application logic and data access components to improve maintainability.

## Security Evaluation

Several basic security measures were implemented during development. These include:

* Administrator authentication using password hashing.
* Session-based access control.
* Prepared SQL statements to reduce SQL injection risks.
* Input validation on forms.
* File type validation for uploaded images.

Although these controls improve security, the prototype should not be considered production-ready. Additional security controls would be required in a commercial environment.

## Limitations

The project was developed as a prototype within a limited timeframe. As a result, several advanced features were not implemented.

Examples include:

* Email notifications.
* User account registration.
* Multi-image galleries.
* Advanced reporting and analytics.
* Real-time adoption tracking.

The system was tested using fictional sample data only and was not evaluated by real rescue centre staff or adopters.

## Future Improvements

Future development could include:

* Multi-image support for animal profiles.
* User registration and applicant accounts.
* Email confirmation and notification services.
* Enhanced search functionality.
* Mobile-first responsive design improvements.
* Reporting and analytics dashboards.

## Conclusion

The completed prototype successfully demonstrates how a web-based system can support animal rescue centres in managing animal profiles and adoption applications. The project met its primary objectives and provides a suitable foundation for future development.
