from django.shortcuts import render, get_object_or_404, HttpResponseRedirect, HttpResponse
from django.urls import reverse
from resume import contact

# Create your views here.

def index(request):
    return render(request, 'resume/index.html')

def contact_(request):
    response = request.POST['response']
    name = request.POST['name']
    email = request.POST['email']
    message = request.POST['message']
    if (contact.send_form(request, response, name, email, message)):
        return HttpResponse(status = 200)
    else:
        return HttpResponse(status = 500)
