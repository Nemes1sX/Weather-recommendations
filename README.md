# Weather-recommendations
Provides clothes recommendations depending on the weather
# Install instructions 
- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
# How to use?
You can use the following example as a starting point for your application.
GET /api/products/recommended/:city
For the next 3 days depending on the forecast select random 2 items that would match the weather
forecast.
__Example output__
```
{
    "city": "vilnius",
    "recommendations": [
        {
            "weather_forecast": "clear",
            "date": "2021-05-22",
            "products": [
                {
                    "sku": "UM-13",
                    "name": "Synergistic Leather Hat",
                    "price": "94.68"
                },
                {
                    "sku": "UM-18",
                    "name": "Heavy Duty Iron Hat",
                    "price": "10.76"
                }
            ]
        },
        {
            "weather_forecast": "heavy-rain",
            "date": "2021-05-23",
            "products": [
                {
                    "sku": "HAT-15",
                    "name": "Pink hat",
                    "price": "6.07"
                },
                {
                    "sku": "UM-1",
                    "name": "Black Umbrella",
                    "price": "10.11"
                }
            ]
        },
        {
            "weather_forecast": "light-rain",
            "date": "2021-05-24",
            "products": [
                {
                    "sku": "HAT-15",
                    "name": "Pink hat",
                    "price": "6.07"
                },
                {
                    "sku": "UM-1",
                    "name": "Black Umbrella",
                    "price": "10.11"
                }
            ]
        }
    ]
}
```
