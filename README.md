# Rest API Project 👽
This is the project assignment of the course DT173G, Webbutveckling III at Mittuniversitetet HT20.

The website created for this project: https://studenter.miun.se/~idgu2001/dt173g/projekt/public/


## Assignment 💻
👽 Create a Rest API that is public to GET. \
👽 POST/PUT/DELETE should be protected with a token given by a log in website, https://github.com/igundhammar/projekt-login, also created for this project. \
👽 The API should use JSON as format. \
👽 A client should consume the Rest API - https://github.com/igundhammar/project-client.

## Installation ✔️


### How do I download this repository?
It's simple! Just run the command `git clone https://github.com/igundhammar/projekt-rest.git`

## Questions? 🤔
### How can I use this project?
**Note**: This is intended for personal use and should only be used on your own development server.
If you want to use this Rest API on your own - make sure you have PHP installed on your local PC along with a local server and a database. 
Set up your database and edit the `config/Database.php` file with your personal database credentials.
Note that your database tables must match the parameters in `classes/Course.php`, `classes/Website.php` and `classes/WorkExperience.php`.

You can also use this Rest API with an API testing tool such as ARC or Postman but note that you will need a valid token for some of the methods.

This web service is free to GET, but needs a valid token to POST, PUT or DELETE. 
There are several endpoints of this Rest API but they all use 3 database tables - courses, workexperiences and websites.

#### Endpoints to use with GET.
https://studenter.miun.se/~idgu2001/writeable/projekt-restapi/courses.php

https://studenter.miun.se/~idgu2001/writeable/projekt-restapi/workexperiences.php

https://studenter.miun.se/~idgu2001/writeable/projekt-restapi/websites.php

#### Endpoints to use with POST.

`https://studenter.miun.se/~idgu2001/writeable/projekt-restapi/courses.php?token=<token>`

`https://studenter.miun.se/~idgu2001/writeable/projekt-restapi/workexperiences.php?token=<token>`

`https://studenter.miun.se/~idgu2001/writeable/projekt-restapi/websites.php?token=<token>`

where `<token>` is the valid token from authorized log in.

#### Endpoints to use with PUT/DELETE.

`https://studenter.miun.se/~idgu2001/writeable/projekt-restapi/courses.php?id=<number>&token=<token>`

`https://studenter.miun.se/~idgu2001/writeable/projekt-restapi/workexperiences.php?id=<number>&token=<token>`

`https://studenter.miun.se/~idgu2001/writeable/projekt-restapi/websites.php?id=<number>&token=<token>`

where `<number>` is the id of the specified course/job/website and `<token>` is the valid token from authorized log in.


If you want access to test the website with CREATE/UPDATE/DELETE, you can contact me and I will provide you with the user information to log in.

Start coding! 🙂
