# QuintypeTest

# I did not used any framwork in this task. i just did with core php and try to used OOP Concept.

Discription of folders :- 
1. js- include  js file of index.php and cabs.php
2. css- include css of both page.
3. database- include .sql database of this task , you only need to import .sql file.

Discriptions of pages

Pages
--------
header.php (include js and css library)
footer.php (include end of body and html)

i include both page on index.php and cab.php to minimize the code



Login
---------

1. index.php :- befor booking cab i would like to take name and number of user so in this page there are two inputs, first one is for name which is optional and second one is mobile number which is mendetory. 

2. index.js :- which include all js of index.php

3 userHandalar.php :- in this page i recive all get and post method which come from index.js(for login)

4. User.php :- this page validate user is exist or not , if not exist then create new user in user table .

Logout
--------
1 logout.php :- this page destroy the session

Configuration File
------------------
1. Connection.php :- in this page include cofiguration of database


Cab
-------

1. cabs.php :- after successfull login redirected to cabs.php, which will show all available cabs. this page also show nearest cab on the basis of given pickup location , afer conformation of pickup location i will ask about cab color(by default normal color) and drop location. when you click on "Let's Go" button your trip time will start. when click on "Finish Trip" , it will show Total Distance, Total Time and Total Cost in dogecoins.

2. cab.js :- which include all the js of cabs.php

3. cabHandaler.php:-  in this page i recive all get and post method which come from cab.js 

4. CabModel.php :- in this page, there are four main function i defined :- 
  
  i)   getAllCabs()    - get all the available cabs
  ii)  getNearestCab() - in this function i find nearest cab on the basis of given pickup location (Cab has all ready some starting postion or drop position)
  iii) bookCab()       - this function will book your cab ,with pickup and drop location
  iv) finishTrip()     - this function will end your trip and calculate Total Distance, Total Time and Total Cost.
  
  
  
  -------------------------------------------------------------------------------------------------------------------------
  Database 
  -------
  1) Database Name :- Taxi_Service
 
 Database Table
 --------------
 1) User - this page store user information like name, mobile no, created date
 2) cabs -  initially i supposed that i have some cabs with some location 
 3)cab_running_status - when user book their cabs all the information store in this table including pickup location, drop location, pickup time , drop time , cab number etc.
 
  
  
  
  
  
  
  


