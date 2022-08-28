# Mytheresa - Code Challenge

API application to return a list of products, that is also filterable.

## Features
- [PHP](https://www.php.net/) >= 8.1.9
- [Symfony](https://symfony.com/) >= 6.1
- [PostgreSQL](https://www.postgresql.org/) = 14
<br />
<br />
- An API to return products using CQRS.
- Products are stored in a PostgreSQL database.
- No query string will return all products. 
- Query string category or priceLessThan can be applied to filter products.
- Products in the boots category have a 30% discount.
- The product with sku = 000003 has a 15% discount.
- When multiple discounts collide, the biggest discount is applied.
## Documentation

### Set up
1. Clone the repository:
```
git clone https://github.com/JamieeBond/mytheresa.git
```
2. Change directory:
```
cd mytheresa
```
3. Build the Docker container:
```
docker compose build --pull --no-cache
```
3. Run the Docker container:
```
docker compose up
```
4. Run database migration:
```
docker exec -it mytheresa_php  php bin/console doctrine:migrations:migrate
```
5. Load fixtures of the base data into the database:
```
docker exec -it mytheresa_php php bin/console doctrine:fixtures:load
```

### Run Tests
1. Load fixtures of the base data into the database:
```
docker exec -it mytheresa_php php bin/phpunit
```
![Screenshot](./docs/tests.png? "Test results")

### Usage
1. List all products:
```
https://localhost/products
```
![Screenshot](./docs/all_products.png? "Listing all products")
2. List only sandals:
```
https://localhost/products?category=sandals
```
![Screenshot](./docs/category_filter.png? "Listing only sandals")
3. List only products less than 80000:
```
https://localhost/products?priceLessThan=80000
```
![Screenshot](./docs/price_less_than.png? "Listing only products less than 80000")
4. List only boots less than 80000:
```
https://localhost/products?priceLessThan=80000&category=boots
```
![Screenshot](./docs/category_price_less_than.png? "Listing only boots less than 80000")
### Finishing Up
1. Run to stop the Docker containers:
```
docker compose down --remove-orphans
```



