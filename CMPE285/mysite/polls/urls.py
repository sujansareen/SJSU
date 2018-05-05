from django.urls import path

from . import views

urlpatterns = [
    # ex: /boostrap welcome
    path('', views.boostrap, name='boostrap'),
    # ex: stock-calculator
    path('stock-calculator', views.index, name='index'),
]