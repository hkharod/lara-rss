# Lara RSS

## Introduction

Lara RSS is a RSS Feed Reader built on Laravel. 

This project aims to show the enormous value of RSS feeds and how they can be coupled with full-text search technologies like Algolia and Elastic Search to extract and analyze data more efficiently for a wide variety of uses. 

This application will help kick start development for projects that require the extraction and indexing of RSS feed data. 


## Getting Started

### Requirements

This application is built on Laravel 5.6 so you will need a server or local environment that can support it's requirements. For full details visit the [Laravel Documentation](https://laravel.com/docs/5.6)

* Server with PHP >= 7.1.3
  - OpenSSL PHP Extension
  - PDO PHP Extension
  - Mbstring PHP Extension
  - Tokenizer PHP Extension
  - XML PHP Extension
  - Ctype PHP Extension
  - JSON PHP Extension
* Composer
* MySQL

### Installation

* Clone or extract this repository into your destination folder
* Install Dependencies using `composer install`
* Run the included database migrations by running `php artisan migrate`


## Usage

This project makes use of Laravel Scout, Laravel 5 Feeds by Will Vincent and the Simple Pie PHP Library. 

### Algolia Search

By default, Laravel Scout ships with an Algolia driver for full-text search capabilities. Please check the `.env.example` file for the credentials you will need if you will be using Algolia. You can create a free account [here](https://www.algolia.com/). You can add up to 10,000 records for free with Algolia. Another option is to swap out the Algolia driver and use Elastic Search which is open source but will have server requirements.

### The Basics

The application comes with user authentication so start by registering an account. 

### Sources
The Source Model will house all your RSS Feed sources.

Start by adding a RSS Source with a title and a valid RSS URL.
![Lara RSS Sources](http://harbind.com/img/LaraRSS-Sources1.png)

From this page, you'll be able to manually execute the extraction of your RSS sources and see when they were last updated. 


### Items
The Item model will store all of your extracted feed items. This model can be made to be "Searchable" by adding `use Searchable;` to the Item model in `App\Item`

The User Homepage will display your latest feed items. 

![Lara RSS Sources](http://harbind.com/img/LaraRSS-Home.png)


### SourcesController and SourceActions trait
The SourcesController comes with a SourceActions trait where you can add your own methods to run before or after a source is executed. 

The method `ExecuteSource($id)` in the SourcesController currently uses the lone feedRun trait method to extract feed data for a specific source.


