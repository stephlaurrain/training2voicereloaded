# -*-coding:utf-8 -*

import os
from os import path
import sys
import random
from datetime import datetime
from time import sleep
import json
import logging
import inspect
from selenium.webdriver.chrome.service import Service
from selenium import webdriver
from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.by import By 
from selenium.webdriver.support.ui import WebDriverWait 
from selenium.webdriver.support import expected_conditions as EC 
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.keys import Keys

class Bot:
      
        #def __init__(self):                
                

        def trace(self,stck):
                #print ("{0} ({1}-{2})".format(stck.function, stck.filename, stck.lineno))
                print ("{0}".format(stck.function))
                #self.log.lg("{0}".format(stck.function))
 
        # init
        def init(self):            
                self.trace(inspect.stack()[0])
                try:
                        options = webdriver.ChromeOptions()       
                        #options.add_argument("user-agent={0}".format(self.jsprms.prms["useragent"]))            
                        options.add_argument("user-data-dir=./chromeprofile")   
                        # ouvrir debugger 
                        #options.add_argument("--auto-open-devtools-for-tabs");
                        options.add_argument('--disable-blink-features=AutomationControlled')
                        options.add_experimental_option("excludeSwitches", ["enable-automation"])
                        options.add_experimental_option('useAutomationExtension', False)
                        # pi / docker                        
                        userAgent = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.61 Safari/537.36";
                        options.add_argument(f"user-agent={userAgent}")
                        options.add_argument("--start-maximized")

                        
                        # anti bot detection
                        # driver.execute_cdp_cmd('Network.setUserAgentOverride', {"userAgent": 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36'})
                        



                        # driver = webdriver.Chrome(executable_path=self.chromedriverbinpath, options=options)    
                        driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)                  
                        driver.execute_script("Object.defineProperty(navigator, 'webdriver', {get: () => undefined})")
                        
                        return driver
                except Exception as e:                             
                        print(e)
                        raise


        def newtab(self,url):            
                self.driver.execute_script("window.open('{0}');".format(url))
                self.driver.switch_to.window(self.driver.window_handles[-1]) 
                
        def main(self):
                          
                try:
                        self.rootApp = os.getcwd()
                        # InitBot
                        nbargs = len(sys.argv)
                        self.trace(inspect.stack()[0])     
                        self.driver = self.init() 
                        # self.driver.get("http://localhost:8080")
                        #self.openmyadmin()    
                        #self.openbo()                 
                        input()
                        self.driver.close()
                        ##)  

                        #ONGLETS
                        #driver.switch_to.window(driver.window_handles[-1])       

                except Exception as e:
                        self.driver.close()
                        raise
            


#INIT
bot = Bot()
bot.main()

              
               
    

        
                

        

