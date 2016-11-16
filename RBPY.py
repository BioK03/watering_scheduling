import RPi.GPIO as GPIO ##Import GPIO library
import json
import sys
from threading import Thread
import time

## Setup GPIO I/O PIns to output mode
GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)
GPIO.setup(7, GPIO.IN) ## This pin is used to read impulsion from sensor
GPIO.setup(11, GPIO.OUT) ## This pin controls the zone 1
GPIO.setup(13, GPIO.OUT) ## This pin controls the zone 2
GPIO.setup(15, GPIO.OUT) ## This pin controls the zone 3
GPIO.setup(19, GPIO.OUT) ## This pin controls the zone 1 ligths
GPIO.setup(21, GPIO.OUT) ## This pin controls the zone 2 ligths
GPIO.setup(23, GPIO.OUT) ## This pin controls the zone 3 ligths

## global variables
litre = 0
working = False

## Thread for counting pulse and litre of water
class WaterCounter(Thread):
    def __init__(self):
        Thread.__init__(self)

    def run(self):
        global litre
        global working
        pulsation = 0
        pulse = 0
        previousPulse = 0

        ## while we are water
        while working :
            previousPulse = pulse 
            pulse = GPIO.input(7)

            ## detection of high-to-low transition at the end of a pulse
            if(previousPulse == 1 and pulse == 0): 
                pulsation = pulsation + 1

            ## increase amount of litre every 450 pulses
            if(pulsation >= 450):
                pulsation = 0
                litre = litre + 1
                print("thread litre")
                print(litre)
                
## Thread for simulate sensor 250 Hz pulse
class SimCapt(Thread):
    GPIO.setup(7, GPIO.OUT) ## This pin is used to write impulsion from sensor
    def __init__(self):
        Thread.__init__(self)

    def run(self):
        while True :
            GPIO.output(7, True)
            time.sleep(0.002)
            GPIO.output(7, False)
            time.sleep(0.002)
            
            
def arrosage():
    ## initialisation GPIO
    GPIO.output(11,False)
    GPIO.output(13,False)
    GPIO.output(15,False)
    GPIO.output(19,False)
    GPIO.output(21,False)
    GPIO.output(23,False)
    ## variables
    global litre
    global working
    currentZone = 0
    currentWaterDesired = 0
    zones = [11, 13, 15] ## matche zone number with pine number
    ## start simulation of sensor
    simCapt = SimCapt()
    simCapt.start()

    ## Loop this forever
    while True:
        try:
            ## open programmation file
            with open("/var/www/html/io/output.json", "r+") as json_file:
                json_data = json.load(json_file)
                
                ## if nothing is planned         
                if(len(json_data["programmation"]) < 1):
                    ## but we were watering
                    if(litre >= 1):
                        ## archive
                        with open("/var/www/html/io/history.json", "r+") as json_file_arch: 
                            json_data_arch = json.load(json_file_arch)
                            archive = {"zone" : currentZone, "nbLitres" : litre}
                            json_data_arch["historique"].insert(0, archive)
                            json_file_arch.seek(0)
                            json.dump(json_data_arch, json_file_arch)
                        ##reset GPIO
                        GPIO.output(zones[currentZone-1], False)

                    ## reset
                    working = False
                    currentZone = 0
                    litre = 0
                    currentWaterDesired = 0
                    
                ## if somethings is planned
                if(len(json_data["programmation"]) >= 1):                
                    ## and it a new programmation
                    if not working:
                        ## setup zone water
                        working = True
                        currentZone = int(json_data["programmation"][0]["zone"])
                        GPIO.output(zones[currentZone-1], True)
                        waterCounter = WaterCounter()
                        waterCounter.start()
                        
                    ## if planned zone has changed   
                    if(currentZone != 0 and currentZone != int(json_data["programmation"][0]["zone"])):
                        ## archive old one
                        with open("/var/www/html/io/history.json", "r+") as json_file_arch: 
                            json_data_arch = json.load(json_file_arch)
                            archive = {"zone" : currentZone, "nbLitres" : litre}
                            json_data_arch["historique"].insert(0, archive)
                            json_file_arch.seek(0)
                            json.dump(json_data_arch, json_file_arch)        
                        ## reset
                        litre = 0
                        GPIO.output(zones[currentZone-1], False)     
                        ## setup new zone water
                        currentZone = int(json_data["programmation"][0]["zone"])
                        GPIO.output(zones[currentZone-1], True)
                        
                    ## update goal
                    currentWaterDesired = int(json_data["programmation"][0]["nbLitres"])

                    ## if goal is achieve
                    if(litre >= currentWaterDesired):
                        ## archive
                        with open("/var/www/html/io/history.json", "r+") as json_file_arch: 
                            json_data_arch = json.load(json_file_arch)
                            archive = {"zone" : currentZone, "nbLitres" : litre}
                            json_data_arch["historique"].insert(0, archive)
                            json_file_arch.seek(0)
                            json.dump(json_data_arch, json_file_arch)    
                        ## reset
                        GPIO.output(zones[currentZone-1], False)
                        working = False
                        currentZone = 0
                        litre = 0
                        currentWaterDesired = 0
                        ## delete achieved plan
                        del json_data["programmation"][0]
                        json_file.seek(0)
                        json_file.truncate()
                        json.dump(json_data, json_file)

                ## set ligths
                if(json_data["eclairage"]["1"]=="1"):
                    GPIO.output(19, True)
                if(json_data["eclairage"]["1"]=="0"):
                    GPIO.output(19, False)
                if(json_data["eclairage"]["2"]=="1"):
                    GPIO.output(21, True)
                if(json_data["eclairage"]["2"]=="0"):
                    GPIO.output(21, False)
                if(json_data["eclairage"]["3"]=="1"):
                    GPIO.output(23, True)
                if(json_data["eclairage"]["3"]=="0"):
                    GPIO.output(23, False)
                    
            ## console log lights and water states     
            print("GPIO eclairage")
            print(GPIO.input(19))
            print(GPIO.input(21))
            print(GPIO.input(23))
            
            print("GPIO arrosage")
            print(GPIO.input(11))
            print(GPIO.input(13))
            print(GPIO.input(15))

        ## error
        except: 
            print "error"
            
        ## sleep for limited access file, in second. Reduce it if client wants better precision on watered litre      
        time.sleep(5)

arrosage()
