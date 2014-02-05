# TCPDUMPER

Listen for network traffic, logg everything and report back to base.

## Installation

* Plug it into a ethernet port that your network switch copy all network to.
* By default will ethernet req. a DHCP server.
* To enable the system to export log files make sure it have a working Internet connection. If Internet connection is not possible, make sure the system have proper space to store all logs. The out of the box 16GB might not be enough.

### Alter network setup

The network config in found inside the text file interfaces. Edit to alter the default config. Alternative editor to those that does not know how to use vi/vim is nano.

    sudo vim /etc/network/interfaces

example static IP config. Replace 'iface eth0 inet dhcp' with:

    iface eth0 inet static
    address 192.168.1.1
    netmask 255.255.255.0
    gateway 192.168.1.254

Also make sure you have a proper DNS server configured.

    sudo vim /etc/resolv.conf

Alter the IP to the correct DNS server.

## Usage

* Transfered log files are stored in a central server.
* Device access is done by logging inn on ssh.
