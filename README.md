Sms Send
========

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




Usage
-----

```shell
smscli -n 739778202 -m "It works!"
```


HTTP Access
-----------

install the `smssend-apache` package to be able send your messages on /smssend/?contact=NUMBER&message=some%20nice

See also https://github.com/Spoje-NET/Sms-Input

