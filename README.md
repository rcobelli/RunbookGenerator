# Command Center
##### Utility to create and manage runbooks (instruction manuals)

![Screenshot](screenshot.png)

## Usage
You can either host your own instillation of this program or use my hosted version at [https://dev.rybel-llc.com/runbook](https://dev.rybel-llc.com/runbook)

## Purpose
The purpose of this application was to provide a centralized version control system for user guides/manuals. In my line of work, there a number of repetitive processes that are very tedious. In the cases where it doesn't make sense to automate the task, it is best to create a runbook (or instruction manual). This application allows you to create a runbooks written in Markdown that can be exported to PDFs for easy distribution. It also allows you to version your runbooks so that you can see a detailed log of how the process and/or manual has changed over time.

## Custom Installation
1. Create a new database and import the contents of `RunbookGenerator.sql`
2. Update the credentials in `config example.ini`
3. Rename `config example.ini` to `config.ini`
4. Create a new Google API Credential ([done here](https://console.developers.google.com/apis/credentials)) and place the `client_secret.json` in the root directory of the project
5. Place the code on a server capable of running PHP
