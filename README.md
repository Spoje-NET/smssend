Sms Send
========

![back](E5180s-22.jpg?raw=true)

E5180s-22 message sender

installation
------------

```shell
wget -qO- https://repo.vitexsoftware.com/keyring.gpg | sudo tee /etc/apt/trusted.gpg.d/vitexsoftware.gpg
echo "deb [signed-by=/etc/apt/trusted.gpg.d/vitexsoftware.gpg]  https://repo.vitexsoftware.com  $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/vitexsoftware.list
sudo apt update

sudo apt install smssend
```

Configuration
-------------

Default config file /etc/smssend/smssend.env 

```env
MODEM_PASSWORD="********"
MODEM_IP="192.168.8.12"
MODEM_USERNAME="admin"
```

Usage
-----

```shell
smscli -n 739778202 -m "It works!"
```


HTTP Access
-----------

install the `smssend-apache` package to be able send your messages on `/smssend/?contact=NUMBER&message=some%20nice`

Example

```shell
 curl -v "http://192.168.8.14/smssend/?contact=739778202&message=justworks"
*   Trying 192.168.8.14:80...
* Connected to 192.168.8.14 (192.168.8.14) port 80 (#0)
> GET /smssend/?contact=739778202&message=justworks HTTP/1.1
> Host: 192.168.8.14
> User-Agent: curl/7.88.1
> Accept: */*
> 
< HTTP/1.1 200 OK
< Date: Mon, 25 Mar 2024 20:34:02 GMT
< Server: Apache/2.4.57 (Debian)
< Cache-Control: no-cache, must-revalidate
< Expires: Mon, 26 Jul 1997 05:00:00 GMT
< Content-Length: 90
< Content-Type: application/json
< 
* Connection #0 to host 192.168.8.14 left intact
{"status":"Message was sent: 1","success":true,"message":"justworks","number":"739778202"}
```

See also https://github.com/Spoje-NET/Sms-Input
