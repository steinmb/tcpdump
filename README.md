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

### Configure ntopng/nprobe

Config found in `/usr/local/etc/ntopng`.
Binaries stored at `/usr/local/bin`

## Usage

### Debugging transport

* Transfered log files are stored in a central server.
* Device access is done by logging inn on ssh.

### Analyzing traffic

* Collected data is picked up by ntopng (http://www.ntop.org/products/ntop/)
* Access data is easiest accessed by using the built in web server http://<IP>:3000

Optional. Statistic can be collected by nProbe (http://www.ntop.org/products/nprobe/) and passed on to a central onshore logging system.

    Libraries have been installed in:
    /usr/local/lib

