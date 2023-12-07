## Setup
- Clone the Repository
- Copy Environment Variables: cp .env.local.example .env
- Choose Deployment Option:  sail up -d | docker-compose up -d
- Install Dependencies: sail composer install | docker-compose exec workspace composer install
- Run Database Migrations with Seed: sail artisan migrate --seed | docker-compose exec workspace php artisan migrate --seed

## Testing
Access the API at: http://localhost/api/v1/issues 
Examples:
- http://localhost/api/v1/issues?filters[!is:status_id]=2
- http://localhost/api/v1/issues?filters[is:status_id]=1&filters[in:story_points][0]=1
- http://localhost/api/v1/issues?filters[is:status_id]=1&filters[in:story_points]=1,2,3&page=2
- http://localhost/api/v1/issues?filters[is:status_id]=1&filters[!in:story_points]=1,2&filters[contain:description]=Just think

## Filters Information
#### Access available filters at: 
http://localhost/api/v1/issues/filters
#### Filter Logic: 
See the App\Services and Filterable trait for filter implementation details.

## Available Filter Field Prefixes
- is: "Equals",
- !is: "NotEqua",
- in: "In",
- !in: "NotIn",
- contain: "Contains",
- !contain: "NotContain"


## Potential Improvements
- Enhance Filtering: Add more types of filtering prefixes for additional flexibility.
Filter Relations:
- Enable filtering on related models for more advanced querying.
Default Prefixes for Fields:
- Allow users to choose default prefixes for any filter field.
-Validation Enhancement: Improve and add validation mechanisms for robust error handling.

## Time Investment
Approximately 10-12 hours were spent on this task.

