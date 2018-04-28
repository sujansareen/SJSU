import requests
import sys
import datetime
import time
import json

def calculate_proceeds( allotment, final_share ):
   return int(allotment) * float(final_share);
def calculate_tax_total( final_share, initial_share, allotment, buy_commission, sell_commission):
   return (((float(final_share) - float(initial_share)) * int(allotment) - float(buy_commission) - float(sell_commission))) ; 
def calculate_tax( tax_total, tax_rate):
	return tax_total * float(tax_rate) / 100; 
def calculate_total_purchase_price( allotment, initial_share ):
	return int(allotment) * float(initial_share); 
def calculate_cost(total_purchase_price, buy_commission , sell_commission, tax ):
	return total_purchase_price + float(buy_commission) + float(sell_commission) + tax; 
def calculate_net_profit( proceeds , cost ):
	return proceeds - cost; 
def calculate_return_on_investment( net_profit, cost):
	return net_profit / cost * 100; 
def calculate_break_even( total_purchase_price, buy_commission, sell_commission, allotment ):
	return (total_purchase_price + float(buy_commission) + float(sell_commission)) / int(allotment); 
def getStockData(symbol=""):
	url = "https://api.iextrading.com/1.0/stock/"+symbol+"/realtime-update"
	querystring = {"last":"3","changeFromClose":"true"}
	headers = {
	'Cache-Control': "no-cache",
	'Postman-Token': "b1fea959-9785-46e4-a7f6-99c93c01fbc9"
	}
	try:
		response = requests.request("GET", url, headers=headers, params=querystring)
	except requests.exceptions.RequestException as e:  # This is the correct syntax
		return 'Connection Error'
	return response.text
# Output
def printStockData(data):
	if data == "Unknown symbol" or data == 'Connection Error':
		print(data)
		return
	obj = json.loads(data)["quote"]
	hasPlus = '+' if obj["change"]>0 else ''
	now = datetime.datetime.now()
	print(now.strftime('%a %b %d %H:%M:%S '+time.localtime().tm_zone+' %Y'))
	print(obj["companyName"] +" ("+obj["symbol"]+")")
	changePercent = "%.2f" % ( float(obj["changePercent"])* 100 ) 
	print("%.2f " % obj["latestPrice"] + hasPlus+"%.2f" % obj["change"] +" (" +hasPlus+ changePercent+"%)")

symbol = " "
while symbol:
	symbol = input("Please enter a symbol (empty to quit):")
	if symbol:
		data = getStockData(symbol)
		printStockData(data)
