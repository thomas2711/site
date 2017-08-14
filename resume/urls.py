from django.conf.urls import url
from . import views

app_name = 'resume'
urlpatterns = [
    url('^$', views.index, name="index"),
    url('^contact_$', views.contact_, name="contact_"),
]