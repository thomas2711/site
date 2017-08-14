import smtplib
import requests
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

def send_form(request, response, name, em, msg):

    ip = get_client_ip(request)

    if not is_valid(response, ip):
        return False

    with open('resume/contact.txt') as f:
        l = f.readlines()
        addr = l[0].strip()
        pwd = l[1].strip()
    
    message = MIMEMultipart()
    message['From'] = addr
    message['To'] = addr
    message['Subject'] = 'contact form submission'
    body = "name: " + name + ", email: " + em + ", ip: " + ip + " message:\n" + msg
    message.attach(MIMEText(body, 'plain'))

    try:
        s = smtplib.SMTP(host = 'smtp.gmail.com', port = 587)
        s.starttls()
        s.login(addr, pwd)

        s.sendmail(addr, addr, message.as_string())
        s.quit()
        return True
    except:
        return False


def is_valid(resp, ip):
    print("test")
    secret = open('resume/secret.txt').readline().strip()
    req = requests.post('https://www.google.com/recaptcha/api/siteverify', data = {'secret' : secret, 'response' : resp, 'remoteip' : ip})
    print(req.json())
    return True

def get_client_ip(request):
    x_forwarded_for = request.META.get('HTTP_X_FORWARDED_FOR')
    if x_forwarded_for:
        ip = x_forwarded_for.split(',')[0]
    else: 
        ip = request.META.get('REMOTE_ADDR')
    return ip