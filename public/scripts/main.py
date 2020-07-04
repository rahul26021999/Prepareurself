#!/usr/bin/env python
# coding: utf-8

# In[ ]:
# !pip install google
# !pip install beautifulsoup4

from urllib.parse import urlparse
from bs4 import BeautifulSoup

import sys
import json
import re
import requests
import csv

def is_unique(url, url_list):
    """
        To find whether a given url is a new website link or referring to some old website with internal links.
        Parameters
        ---------------------
        url : str - (url that needs to be checked)
        url_list : list - (list of all previously saved urls)
        ----------------------
        
        return  : bool
    """
    
    for i in range(len(url_list)):
        if url_list[i] in url:
            return False
        
    return True

try:
    from googlesearch import search
except ImportError:
    print("No module named 'google'")

#to search
query = sys.argv[1]
word = query.split()
#print(word[-1])

all_search_results = search(query, tld="co.in",lang='en')

how_many_links = 5

unique_website_links = []

while len(unique_website_links) <= how_many_links:
    
    url = next(all_search_results)
    
    if is_unique(url, unique_website_links):
        
        if any(wd in url for wd in word):
            unique_website_links.append(url)
        else:
            print("No responses found")
            break
     
    dic={"fulfillmentText":"\n".join(unique_website_links)}
    
print(json.dumps(dic))

