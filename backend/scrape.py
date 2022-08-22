import requests
import time
import math
import re
import json
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

def parse_tab(x):
    tab_data = []
    rows = x.find_all('tr')
    for row in rows:
        cols = row.find_all('td')
        cols = [ele.text.strip() for ele in cols]
        tab_data.append([ele for ele in cols if ele]) # Get rid of empty values
    return tab_data

once = True
while once:
    once = False
    try:
        test_site = requests.get('https://tests.stockfishchess.org/api/active_runs')
        tests = json.loads(test_site.text)
        for key in tests.keys():
            test_id = str(key)
            test = tests[key]
            if not 'result_info' in test:
                continue
            llr = 0
            wins = 0
            losses = 0
            draws = 0
            elo = 0
            if 'args' in test and 'sprt' in test['args'] and 'llr' in test['args']['sprt']:
                llr = test['args']['sprt']['llr']
            if 'results' in test and 'wins' in test['results']:
                wins = test['results']['wins']
                losses = test['results']['losses']
                draws = test['results']['draws']
                total = wins+losses+draws
            score = wins + 0.5*draws
            if score > 0:
                score = wins + 0.5*draws
                perc = score / total
                elo = -400*math.log(1/perc - 1, 10)
            
            sql_str = "INSERT INTO `tests` (`submit_id`, `submit_date`, `test_id`, `llr`, `total`, `wins`, `losses`, `draws`, `elo`) VALUES (NULL, current_timestamp(), '"+escape(test_id)+"', '"+escape(str(llr))+"', '"+escape(str(total))+"', '"+escape(str(wins))+"', '"+escape(str(losses))+"', '"+escape(str(draws))+"', '"+escape(str(elo))+"')"
            mycursor = mydb.cursor()
            mycursor.execute(sql_str)
            mydb.commit()
            if(not exists(test_id)):
                test_start_date = test['start_time']
                test_user = test['args']['username']
                test_branch = test['args']['new_tag']
                test_diff = ''
                test_elo_text = str(test['results_info']['info'])
                test_type_text = test['args']['tc']
                test_descr = test['args']['msg_base']
                test_type = 0
                elo0 = 0
                elo1 = 0
                alpha = 0
                beta = 0
                test_result = 0
                obj_tab = str(test)
                if 'sprt' in test['args']:
                    test_type_text = test_type_text + " sprt"
                    test_type = 1
                    elo0 = test['args']['sprt']['elo0']
                    elo1 = test['args']['sprt']['elo1']
                    alpha = test['args']['sprt']['alpha']
                    beta = test['args']['sprt']['beta']
                sql_str = "INSERT INTO `test_unique` (`test_id`, `submit_date`, `test_start_date`, `test_user`, `test_branch`, `test_diff`, `test_elo_text`, `test_type_text`, `test_descr_test`, `llr`, `total`, `wins`, `losses`, `draws`, `elo`, `test_type`, `elo0`, `elo1`, `alpha`, `beta`, `result`, `test_site`) VALUES ('"+escape(test_id)+"', current_timestamp(), '"+escape(test_start_date)+"', '"+escape(test_user)+"', '"+escape(test_branch)+"', '"+escape(test_diff)+"', '"+escape(test_elo_text)+"', '"+escape(test_type_text)+"', '"+escape(test_descr)+"', '"+escape(str(llr))+"', '"+escape(str(total))+"', '"+escape(str(wins)) \
                             +"', '"+escape(str(losses))+"', '"+escape(str(draws))+"', '"+escape(str(elo))+"', '"+escape(str(test_type))+"', '"+escape(str(elo0))+"', '"+escape(str(elo1))+"', '"+escape(str(alpha))+"', '"+escape(str(beta))+"', '"+escape(str(test_result))+"', '"+escape(str(obj_tab))+"')"
                mycursor = mydb.cursor()
                mycursor.execute(sql_str)
                mydb.commit()
            else:
                sql_str = "UPDATE `test_unique` SET `submit_date`=current_timestamp(), `llr`="+escape(llr)+", `total`="+escape(total)+", `wins`="+escape(wins)+", `losses`="+escape(losses)+", `draws`="+escape(draws)+", `elo`="+escape(elo)+" WHERE `test_id` = '"+escape(test_id)+"'"
                mycursor = mydb.cursor()
                mycursor.execute(sql_str)
                mydb.commit()
    except Exception as e:
        print(traceback.format_exc())
