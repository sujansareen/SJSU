import sys

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

# Output
print("Compute Your Profit: ")
symbol = input("Ticker Symbol: ")
print
allotment = input("Allotment: ")
print
final_share = input("Final Share Price: ")
print
sell_commission = input("Sell Commission: ")
print
initial_share = input("Initial Share Price: ")
print
buy_commission = input("Buy Commission: ")
print
tax_rate = input("Capital Gain Tax Rate (%): ")
print

# Calculate
proceeds = calculate_proceeds(allotment, final_share)
tax_total = calculate_tax_total(final_share, initial_share, allotment, buy_commission,sell_commission) 
tax = calculate_tax(tax_total,tax_rate)
total_purchase_price = calculate_total_purchase_price(allotment,initial_share)
cost = calculate_cost(total_purchase_price,buy_commission,sell_commission,tax)
net_profit = calculate_net_profit(proceeds, cost)
return_on_investment = calculate_return_on_investment(net_profit,cost)
break_even = calculate_break_even(total_purchase_price,buy_commission,sell_commission,allotment)

# Profit Report Output
print("PROFIT REPORT: ")
print("Proceeds")
print("$%.2f" % proceeds)
print
print("Cost")
print("$%.2f" % cost)
print
print("Cost details:")
print("Total Purchase Price")
print(allotment + " x $" + initial_share + " = " + "%.2f" % total_purchase_price)
print("Buy Commission = %.2f" % float(buy_commission))
print("Sell Commission = %.2f" % float(sell_commission))
print("Tax on Capital Gain = " + tax_rate + "% of $" + "%.2f" % tax_total + " = " + "%.2f" % tax + '\n')
print("Net Profit")
print("$" + "%.2f" % net_profit + '\n')
print("Return on Investment")
print("%.2f" % return_on_investment + "%" + '\n')
print("To break even, you should have a final share price of ")
print("$" + "%.2f" % break_even + '\n')