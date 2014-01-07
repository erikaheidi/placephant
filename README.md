##placephant

This is a very simple placeholder project featuring lovely elephpants.
It's built with Silex+Flint.

You can use this project as a base for your very own image placeholder. Just change the settings in the app/config/config.yml file and use your own image resources.

###Usage

You can point the src of your images direct to http://placephant.com with the desired width and height as path parameters, as shown below:

300x250 colored image:
``<img src="http://placephant.com/300/250"/>``

100x100 square colored image (just need to provide the width): 
``<img src="http://placephant.com/100"/>``

300x250 black and white image: 
``<img src="http://placephant.com/g/100/200">``
``<img src="http://placephant.com/100/200?filter=bw">``

verbose mode - shows the image dimensions on b&w image
``<img src="http://placephant.com/v/100/200">``

300x250 sepia image: 
``<img src="http://placephant.com/300/250?filter=sepia"/>``

###Requirements (dev)

Placephant requires php >= 5.4 and the php5-imagick extension.

###Vagrant

A Vagrant setup is provided, using the **Ansible** _Provisioner_.  

####Instructions

You'll need Vagrant, VirtualBox and Ansible. 
This setup was tested on Ubuntu 12.04 with Vagrant 1.4.2, VirtualBox 4.3.6 and Ansible 1.4.1 .

Linux users will also need ``nfs-common`` and ``nfs-kernel-server`` in order to use the NFS shared folders (increases performance).

After the ``vagrant up``, the application will be running at `192.168.33.101` .

####Troubleshooting

**Ansible hangs forever on ``composer install``** : hit ctrl+c to cancel the provision, then run it again. It will finish the other tasks, then you can log in and run ``composer install`` manually. This might be caused by composer asking for github credentials, or some other error from github - so its better to login with `vagrant ssh` and check what's going on.
