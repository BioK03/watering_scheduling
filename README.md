# watering_scheduling

Project developed by two students from Polytech Lyon.

## Embedded computing project
Goal : Create a water scheduling software to pilot a 3-way valve and 3 lights.

## Production platforms
<img src="http://www.boulineau.com/wp-content/uploads/2013/01/raspberry-pi-model-b-512mb.jpg" alt="Raspberry Pi Picture" style="width: 200px;"/>
The software is running on a Raspberry Pi B and interacts with its environment via the GPIO.

It is composed of two parts, that have to be installed in /var/www/html (assuming you have a web server like lttpd or apache).

## Python Script
The script will check the interface file for modifications. It will write on the GPIO if it has to water or/and light the garden.

It's composed of a writing-only part (that generate impulsions to simulate the water counter) and of an intelligent part that follow orders and read the water counter.

Once a task is accomplished, it will notify the website by adding a line in the water history.

## Interface file
The file io/output.json is the interface file. It is composed of light and water orders that are read by the Python script.

## Website
The website, developed in HTML5, CSS3, JS, MDBootstrap and Font-Awesome, is the responsive view for the user. He can overview the system and create light or water orders.
