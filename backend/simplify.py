import requests
import time
import math
import re
import sys, traceback
import mysql.connector
from sqlescapy import sqlescape

mydb = mysql.connector.connect(
  host="localhost",
  user="stockfish",
  password="REMOVED",
  db="stockfish"
)

def escape(x):
    return sqlescape(str(x))

def exists(testid):
    global mydb
    mycursor = mydb.cursor()
    mycursor.execute("SELECT * FROM `test_unique` WHERE `test_id` = '"+escape(testid)+"' LIMIT 0, 1")
    myresult = mycursor.fetchall()
    return len(myresult) > 0


mycursor = mydb.cursor()
mycursor.execute("SELECT * FROM `tests` WHERE submit_date <= DATE_SUB(NOW(), INTERVAL 1 MINUTE) ORDER BY submit_id DESC LIMIT 50000")
recent_tests = mycursor.fetchall()

test_counts = {}
delids = []
for test in recent_tests:
    test_id = test[2]
    total = test[4]
    submit_id = test[0]
    if (test_id in test_counts) and ((total >= 1000 and test_counts[test_id]-total <= 200) or (test_counts[test_id]-total <= 50)):
        delids.append(submit_id)
    else:
        test_counts[test_id] = total

for id in delids:
    sql_str = "DELETE FROM `tests` WHERE `tests`.`submit_id` = "+escape(id)
    mycursor = mydb.cursor()
    mycursor.execute(sql_str)

mydb.commit()
