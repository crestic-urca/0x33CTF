# **0x33CTF** *v.0.0*

## Hello and welcome to 0x33-CTF!

This tool will allow you to organize your own CTF simply and efficiently.  
In this page you will find how to use the tool.

## Installation

***

### Requirements

The tool uses port 80 to communicate with the web interface

### Commands

To test the tool : 

* Go to the [Dockerfile](/Dockerfile) and remove the '#' from lines 50-51-52
* and go to [Config](/.env.docker) and change the value of 'APP_DEBUG' to 'true' (line 4)
* Then compile the project and run it, you will have a version of the tool already filled with random data. This will allow you to see how it works and to test it.

To run the tool, you need to compile it, with the command : 

```bash
docker build -t 0x33ctf [project path]
```

Then launch it with the command, for example: 

```bash
docker run -p 80:80 -d 0x33ctf
```

## Use

***

### Configuration

As far as configuration is concerned, everything is done directly on the site, but a few details are necessary. The first account created is the **administrator account**, it is only him who will be able to configure the tool and modify the configuration if needed.

## Description

***

**0x33CTF** is a tool that is used to create CTFs with challenges of different categories.  
It will allow to launch and stop Docker images of challenges, to do them safely, the tool manages the display of the challenge launch, when the challenge is ready, it displays the ports to use to be able to connect to it in ssh.  
It also manages the teams and allows the players to create their teams and to compose them. The configuration of the CTF is done manually on the site, as soon as the first user is created, who is the CTF administrator.  
The configuration of the CTF can be totally modified at any time, so the dates can be changed as well as the description, the name, and the size of the teams.

## Project progress

***

![80%](https://progress-bar.dev/80)

## Upcoming features

***

|functionality  |progress | validation  |Added to the version  |
|---------|---------|---------|---------|
|Help page     |   ![100%](https://progress-bar.dev/100)      |    ✅     |    V 1.0     |
|launching docker images     | ![5%](https://progress-bar.dev/5)        |  🔲       |         |
|loading data for the ssh connection     | ![0%](https://progress-bar.dev/0)        |   🔲      |         |
|     |         |         |         |