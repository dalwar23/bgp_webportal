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
    dbQuery = __createQuery()
    # Execute SQL query
    try:
        prefixList = []
        _pt = pytricia.PyTricia()
        cur.execute(dbQuery)
        result = cur.fetchall()
        for row in result:
            #prefixList.append(row[0])
            _pt.insert(row[0],row[0])
        _net = _pt.get(_ip)
        print (_net)
    except ValueError as e:
        return False
# Define __createQuery
def __createQuery():
    tableName = 't_delegation_s1'
    querySegment_1 = "SELECT prefix_more FROM "
    querySegment_2 = tableName
    completeQuery = querySegment_1 + querySegment_2
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
