#!/usr/bin python3 -tt
# Character_encoding: UTF-8
# -------------------------------------------------------------
# Author: Dalwar Hossain (dalwar014@gmail.com)
# Python Interpreter: >= 3.4
# mySQL Database Version: 5.6.28
# mysql Connector Version: 2.1.5
# -------------------------------------------------------------
# Import Built-in Libraries
import sys
import os
import gc
# Import pytricia to match longest prefix
import pytricia
# Import custom functions
import dbConnection
# Define __importPrefix(cnx) to import all the prefixex from Database
def __importPrefix(cnx, _ip):
    # Prepare a cursor object
    cur = cnx.cursor()
    # Create MYSQL database query string
    __dbQuery_m = __createQuery("prefix_more")
    __dbQuery_l = __createQuery("prefix_less")
    # Execute SQL query
    try:
        flag = "prefix_more"
        _pt_m = pytricia.PyTricia()
        cur.execute(__dbQuery_m)
        result = cur.fetchall()
        for row in result:
            _pt_m.insert(row[0], row[0])
        _net = _pt_m.get(_ip)
        if(_net):
            print(flag + "|" + _net)
        else:
            _flag = "prefix_less"
            _pt_l = pytricia.PyTricia()
            cur.execute(__dbQuery_l)
            result = cur.fetchall()
            for row in result:
                _pt_l.insert(row[0], row[0])
            _net = _pt_l.get(_ip)
            if(_net):
                print(_flag + "|" + _net)
    except ValueError as e:
        return False
# Define __createQuery
def __createQuery(column_name):
    tableName = 'v_current_prefix'
    querySegment_1 = "SELECT "
    querySegment_2 = column_name
    querySegment_3 = " FROM "
    querySegment_4 = tableName
    completeQuery = querySegment_1 + querySegment_2 + querySegment_3 + querySegment_4
    return completeQuery
# Define main function
def main():
    argLen = len(sys.argv)
    _ip = sys.argv[1]
    if argLen == 2:
        # Connect to Database and list available more specific prefixex
        cnx = dbConnection.connect()
        if cnx:
            # Connection to DB is OK
           __importPrefix(cnx, _ip)
        else:
            return False
    else:
        return False
# -------------------------------------------------------------
# This is a standard boilerplate that calls the main() function
if __name__ == '__main__':
	main()
