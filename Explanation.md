### Requirement

A WordPress site needs user registration & login functionality in a public page. Registered users have a custom user role & they can see customized data based on the user role.

The email is the required data on creating an account. Password is another required field, but has provision to skip password.

When creating an account, use the submitted email as the email address. Set submitted password as password. Request random data from randomuser.me API and set first name, last name & country from the API response.

When saving a fake first name & last name, we need to verify that combination must be unique because later we need to use that combination or email to update user roles through custom REST API endpoint.

Need 3 custom user roles.

1. Cool kid :- When creating a user from the front end registration form, this will be the default user role. He can login & view his details like first name, last name, country, email, address & role.
2. Cooler kid :- He can login & view his details. Additionally, he can view all users' lists with first name, last name & country. He can't view other user's email & roles.
3. Coolest kid :- He can login & view his details. Additionally, he can view all users' lists with all data like first name, last name, country, email address & role.

Need to develop a restricted API endpoint to update user roles by passing email or first name and last name with user role. 3 possible user roles that can be updated are cool kid, cooler kid & coolest kid. To update user roles through REST API, credentials of a user with admin privilege required.

### Technical details

1. Character

Requirement is when an account was created, create a fake character with first name, last name, country, email address & role properties.

There are possibilities to use a custom table or a custom post type for fake characters. In WordPress user model, first name, last name, email & role properties already exist. For additional properties, I can use custom user meta. Additionally, I need to use meta query in multiple situations and WordPress user query allows this. WordPress has a nice role and permission management options. By considering all these conditions, choosing the WordPress user model helps me to ensure compatibility & flexibility with other plugins, themes & code snippet.

2. Register form, Login form & user list
To display all these details, a single short code is enough. We can display details based on query parameters and logged in status.

To display the user list, we can use WP_User_Query.

3. REST API endpoint to update role
For the custom API endpoint, we can extend WP_REST_Controller.

### Flowchart

![Register](docs/img/register.png)

![Login](docs/img/login.png)


# How to use the plugin

You can download the latest version of plugin from [GitHub repo](https://github.com/sarathlal/cool-kids-network/releases).

## Shortcode Documentation

The `[cool_kids_network]` shortcode dynamically displays content based on the logged-in status and role of the user:

- **Logged-in Users**:
  - Displays the user's own details (e.g., name, email, role).
  - Displays other user details based on their role and permissions:
    - **Cool Kid**: Only their own data.
    - **Cooler Kid**: Their own data and some details of other users.
    - **Coolest Kid**: Full details of all users.

- **Guests (Not Logged In)**:
  - Displays a login form by default.
  - Provides a link to switch to the registration form.

### Usage

Add the shortcode to any page, post, or widget:
```
[cool_kids_network]
```

### Form Handling

1. **Login Form**:
   - Guests can log in using their credentials.

2. **Registration Form**:
   - Users can register by providing a valid email and password.

3. **Post-Registration**:
   - After successful registration, users need to log in using the credentials they provided.

## API Documentation

#### Base URL

```
https://yourwebsite.com/wp-json/cool-kids-network/v1
```
#### Endpoint
```
/role
```

Updates the role of a user based on their email or a combination of first and last names. Only users with the `edit_users` capability can access this endpoint.

#### Parameters

| Parameter     | Type   | Required | Description                             |
|---------------|--------|----------|-----------------------------------------|
| `email`       | string | No       | The email address of the user.          |
| `first_name`  | string | No       | The first name of the user.             |
| `last_name`   | string | No       | The last name of the user.              |
| `role`        | string | Yes      | The new role to assign to the user. Must be "cool_kid", "cooler_kid" or "coolest_kid". |

**Note**: You must provide either `email` or both `first_name` and `last_name`.

#### Example Requests

1. **By Email**:
   ```
	curl -X PUT https://yourwebsite.com/wordpress/wp-json/cool-kids-network/v1/role \
	    -u "admin:ZLAG gcHk e41I 37R9 Elmo wyxa" \
	    -H "Content-Type: application/json" \
	    -d '{
	        "email": "user@example.com",
	        "role": "coolest_kid"
	    }'
   ```

2. **By First and Last Name**:
   ```
	curl -X PUT https://yourwebsite.com/wordpress/wp-json/cool-kids-network/v1/role \
	    -u "admin:ZLAG gcHk e41I 37R9 Elmo wyxa" \
	    -H "Content-Type: application/json" \
	    -d '{
	        "first_name": "Alexandra",
	        "last_name": "Jean",
	        "role": "cool_kid"
	    }'
   ```

#### Example Responses

1. **Success**:
   - Status Code: `200 OK`
   - Response:
     ```json
     {
         "status": "success",
         "message": "User role updated successfully.",
         "user_id": 42
     }
     ```

2. **Error: Invalid Role**:
   - Status Code: `400 Bad Request`
   - Response:
     ```json
     {
         "status": "error",
         "message": "Invalid role provided."
     }
     ```

3. **Error: User Not Found**:
   - Status Code: `404 Not Found`
   - Response:
     ```json
     {
         "status": "error",
         "message": "User not found."
     }
     ```

4. **Error: Unauthorized**:
   - Status Code: `401 Unauthorized`
   - Response:
     ```json
     {
         "status": "error",
         "message": "You are not authorized to perform this action."
     }
     ```

#### Authorization
This endpoint requires the user to be logged in and have the `edit_users` capability.

# Notes

### Bash script with WP CLI to create 100 users with role "cool_kid"

     ```
    for i in $(seq 1 100); do
        username="user${i}"
        email="user${i}@example.com"
        first_name="First${i}"
        last_name="Last${i}"
        country="India"

        # Create user
        wp user create "$username" "$email" --role=cooler_kid --user_pass="password${i}"

        # Add custom user meta
        wp user meta update "$username" first_name "$first_name"
        wp user meta update "$username" last_name "$last_name"
        wp user meta update "$username" country "$country"
    done
     ```