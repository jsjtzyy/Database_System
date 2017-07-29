Note: (yingyi zhang)
 (1) The table of messageRider is modified. I added attribute "coordinate" indicating the geolocation of curLocation for further computing.
 (2) The configuration conforms stipulations deployed on cPanel. Specifically, file .env and app.php in view as well as layout folder should be changed if run locally.

Description:
    This project is implemented based on PHP Laravel framework and MySQL database. The system is designed for user to find companion when planning to travel, watch movie or have dinner. Google API is invoked to provide location info and recommended path is computed via Minimum Spanning Tree and Clustering algorithms.
