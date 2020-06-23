import urllib
import json
import os

from urllib.parse import urlparse
from googlesearch import search

from flask import Flask
from flask import request
from flask import make_response

# Flask app should start in global layout
app = Flask(_name_)


@app.route('/webhook', methods=['POST'])
def webhook():
    req = request.get_json(silent=True, force=True)

    print("Request:")
    print(json.dumps(req, indent=4))

    res = makeWebhookResult(req)

    res = json.dumps(res, indent=4)
    print(res)
    r = make_response(res)
    r.headers['Content-Type'] = 'application/json'
    return r

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

def makeWebhookResult(req):
    # if req.get("result").get("action") != "shipping.cost":
    #     return {}
    # result = req.get("result")
    # parameters = result.get("parameters")
    # zone = parameters.get("PHP")

    # cost = {'PHP Intro':'6.85%', 'Allahabad Bank':'6.75%', 'Axis Bank':'6.5%', 'Bandhan bank':'7.15%', 'Bank of Maharashtra':'6.50%', 'Bank of Baroda':'6.90%', 'Bank of India':'6.60%', 'Bharatiya Mahila Bank':'7.00%', 'Canara Bank':'6.50%', 'Central Bank of India':'6.60%', 'City Union Bank':'7.10%', 'Corporation Bank':'6.75%', 'Citi Bank':'5.25%', 'DBS Bank':'6.30%', 'Dena Bank':'6.80%', 'Deutsche Bank':'6.00%', 'Dhanalakshmi Bank':'6.60%', 'DHFL Bank':'7.75%', 'Federal Bank':'6.70%', 'HDFC Bank':'5.75% to 6.75%', 'Post Office':'7.10%', 'Indian Overseas Bank':'6.75%', 'ICICI Bank':'6.25% to 6.9%', 'IDBI Bank':'6.65%', 'Indian Bank':'4.75%', 'Indusind Bank':'6.85%', 'J&K Bank':'6.75%', 'Karnataka Bank':'6.50 to 6.90%', 'Karur Vysya Bank':'6.75%', 'Kotak Mahindra Bank':'6.6%', 'Lakshmi Vilas Bank':'7.00%', 'Nainital Bank':'7.90%', 'Oriental Bank of Commerce':'6.85%', 'Punjab National Bank':'6.75%', 'Punjab and Sind Bank':'6.4% to 6.80%', 'Saraswat bank':'6.8%', 'South Indian Bank':'6% to 6.75%', 'State Bank of India':'6.75%', 'Syndicate Bank':'6.50%', 'Tamilnad Mercantile Bank Ltd':'6.90%', 'UCO bank':'6.75%', 'United Bank Of India':'6%', 'Vijaya Bank':'6.50%', 'Yes Bank':'7.10%'}

    # speech = "The interest rate of " + zone + " is " + str(cost[zone])
    # print("Response:")
    # print(speech)
    # return {
    #     "speech": speech,
    #     "displayText": speech,
    #     #"data": {},
    #     #"contextOut": [],
    #     "source": "BankRates"
    # }
    query_response = req["queryResult"]
    print(query_response)
    text = query_response.get('queryText',None)
    parameters = query_response.get('parameters',None)
    
    all_search_results = search(text, tld="co.in",lang='en')

    res = get_links(all_search_results,text)

    return res

def get_links(all_search_results,text):
    
    num = 5
    unique_links = []
    
    while len(unique_links)<= num:
        
        url = next(all_search_results)
    
        if is_unique(url, unique_links):
            unique_links.append(url)
    
    unique_links = '\n'.join(unique_links)
    
    #unique_links.append('https://www.php.net/')
    #unique_links.append('https://www.w3schools.com/php/DEFAULT.asp')

    speech = "Some links for your help are: {link_res}".format(link_res=unique_links)

    return {
                "fulfillmentText":speech,
  }    


if _name_ == '_main_':
    port = int(os.getenv('PORT', 80))

    print ("Starting app on port %d" %(port))

    app.run(debug=False, port=port, host='0.0.0.0')