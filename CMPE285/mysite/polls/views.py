from django.http import HttpResponse
from django.http import JsonResponse
import json

from .models import Question
from django.shortcuts import render

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




def index(request):
    if request.method == 'POST':
        data = json.loads(request.body)
        proceeds = calculate_proceeds(data["allotment"], data["final_share"])
        tax_total = calculate_tax_total(data["final_share"], data["initial_share"], data["allotment"], data["buy_commission"], data["sell_commission"])
        tax = calculate_tax(tax_total, data["tax_rate"])
        total_purchase_price = calculate_total_purchase_price(data["allotment"], data["initial_share"])
        cost = calculate_cost(total_purchase_price, data["buy_commission"], data["sell_commission"], tax)
        net_profit = calculate_net_profit(proceeds, cost)
        return_on_investment = calculate_return_on_investment(net_profit, cost)
        break_even = calculate_break_even(total_purchase_price, data["buy_commission"], data["sell_commission"], data["allotment"])
        
        return JsonResponse({
            "proceeds":"$%.2f" % proceeds,
            "tax_total":"$%.2f" % cost,
            "tax":tax,
            "total_purchase_price":data["allotment"] + " x $" + data["initial_share"] + " = " + "%.2f" % total_purchase_price,
            "cost":"$%.2f" % cost,
            "net_profit":"$" + "%.2f" % net_profit,
            "return_on_investment":"%.2f" % return_on_investment + "%",
            "break_even":"$" + "%.2f" % break_even,
            "buy_commission" : "%.2f" % float(data["buy_commission"]),
            "sell_commission" : "%.2f" % float(data["sell_commission"]),
            "tax_on_capital_gain" : data["tax_rate"] + "% of $" + "%.2f" % tax_total + " = " + "%.2f" % tax,
        }, safe=False)
    else:
        latest_question_list = Question.objects.order_by('-pub_date')[:5]
        context = {'latest_question_list': latest_question_list}
    return render(request, 'polls/index.html', context)

def detail(request, question_id):
    return HttpResponse("You're looking at question %s." % question_id)

def results(request, question_id):
    response = "You're looking at the results of question %s."
    return HttpResponse(response % question_id)

def vote(request, question_id):
    return HttpResponse("You're voting on question %s." % question_id)

def calculate(request):
    return JsonResponse({'foo':'bar'})