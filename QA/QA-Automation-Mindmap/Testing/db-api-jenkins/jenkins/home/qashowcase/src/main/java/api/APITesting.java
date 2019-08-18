package api;

import com.google.gson.JsonObject;
import io.restassured.RestAssured;
import io.restassured.response.Response;
import io.restassured.specification.RequestSpecification;
import org.testng.Assert;
import org.testng.annotations.Test;
import static io.restassured.RestAssured.*;
import static org.hamcrest.Matchers.*;

// Using http://localhost:8080/swagger-ui.html
// Using http://heatclinic.shiftedtech.com/
// Stop all containers: docker container stop $(docker container ls -aq)
public class APITesting {
    public String localURI = "http://localhost:8080/api/tutorial/1.0/employees/";

    // @Test
    public void getProduct() {
        given().header("Content-Type", "application/json")
                .when().get("http://heatclinic.shiftedtech.com/api/v1/catalog/product/2")
                .then().statusCode(200)
                .assertThat().body("id", equalTo(2))
                .assertThat().body("primaryMedia.title", equalTo("Sweet Death Sauce Bottle"));

        Response response = given().header("Content-Type", "application/json")
                .when().get("http://heatclinic.shiftedtech.com/api/v1/catalog/product/2");

        response.prettyPrint();

        Assert.assertEquals(response.statusCode(), 200);

        response.then()
                .assertThat().body("name", equalTo("Sweet Death Sauce"))
                .assertThat().body("primaryMedia.url", equalTo("/cmsstatic/img/sauces/Sweet-Death-Sauce-Bottle.jpg"))
                .assertThat().body("defaultCategoryId", equalTo(2001));
    }


    // Note: if this method were to have @Test annotation above it, Testng would not recognize it as a test method.
    // No errors will be given because the result will just be "no tests were found"
    // @Test()
    public Response getAllEmployees() {
        System.out.println("Obtaining all current employees.");
        Response response = given().header("Content-Type", "application/json")
                .when().get(localURI);

        response.prettyPrint();
        return response;
    }

    public Response getEmployee(int id) {
        System.out.println("Obtaining employee with id: " + id);
        Response response = given().header("Content-Type", "application/json")
                .when().get(localURI + id);

        response.prettyPrint();
        return response;
    }

    // This GET request gets ALL employees.
    @Test(priority = 1, description = "Get all the current employees: GET practice.")
    public void checkForAllEmployees() {
        Response response = getAllEmployees();

        // Make sure that we received the OK response.
        Assert.assertEquals(response.getStatusCode(), 200);

        // The first assertion with rest assured.
        // Note: If you have multiple objects where they all have a "firstName" then use the usual java array syntax of
        // firstName[0] for the first element, firstName[1] for the second...
        response.then()
                .assertThat()
                .body("firstName[0]", equalTo("John"))
                .body("lastName[0]", equalTo("Doe"))
                .and()
                .body("firstName[1]", equalTo("Jenny"))
                .body("lastName[1]", equalTo("Doe"));

        // Rather than checking with multiple lines, we can make it more concise by using the hasItems method to check
        // for multiple names within an array.
        // Note: if you want to check that an array contains multiple items use the hasItems method with the items in any order.
        response.then()
                .assertThat()
                .body("firstName", hasItems("John", "Jenny", "Clark"));

        response.then()
                .assertThat()
                .body("firstName", hasItems("Clark", "Jenny", "John"));

        // The above can be combined just like the first assertion with rest assured within this method.
        response.then()
                .assertThat()
                .body("firstName", hasItems("John", "Jenny", "Clark"))
                .body("firstName", hasItems("Clark", "Jenny", "John"));
    }

    // This GET request gets only a single employee. The difference from the above get is with the URI:
    // http://localhost:8080/api/tutorial/1.0/employees/
    // vs
    // http://localhost:8080/api/tutorial/1.0/employees/1
    @Test(priority = 2, description = "Get the first employee: GET practice.")
    public void getFirstEmployee() {
        Response response = getEmployee(1);
        Assert.assertEquals(response.statusCode(), 200);
        // Note that employeeId MUST be equal to an integer NOT a string.
        // The Testng/Hamcrest comparison log might confuse you because it will say
        // Expected: 1
        // Actual: 1
        // But it's really comparing the string "1" to the int 1.
        response.then()
                .assertThat()
                .body("employeeId", equalTo(1))
                .body("firstName", equalTo("John"))
                .body("lastName", equalTo("Doe"))
                .body("email", equalTo("john@doe.com"))
                .body("phone", equalTo("555-1212"));
    }

    // POST request CREATES a new object.
    @Test(priority = 3, description = "Add a new employee: POST practice.")
    public void addNewEmployee() {
        System.out.println("Before: ");
        getAllEmployees();

        // Generate the JsonObject with the information that should be saved.
        JsonObject requestParams = new JsonObject();
        requestParams.addProperty("employeeId", 4);
        requestParams.addProperty("firstName", "Johnny");
        requestParams.addProperty("lastName", "Ash");
        requestParams.addProperty("email", "jash@gmail.com");
        requestParams.addProperty("phone", "818-555-5515");

        RequestSpecification request = RestAssured.given();
        // Add a header stating the Request body is a JSON
        request.header("Content-Type", "application/json");
        // Add the Json to the body of the request
        request.body(requestParams.getAsJsonObject());

        // Post the request and check the response
        Response response = request.post(localURI);

        response.prettyPrint();
        // Notice that we are checking for status code 201 rather than the usual 200 because
        // 201 means that the request has been fulfilled and has resulted in one ore more new resources being created.
        Assert.assertEquals(response.statusCode(), 201);

        System.out.println("After: ");
        response = getAllEmployees();
        // Notice how instead of directly comparing the firstName object using equalTo(),
        // we are instead using hasItem() so that the method will iterate through the entire
        // object array for an element that we specify.
        response.then()
                .assertThat()
                .body("firstName", hasItem("Johnny"))
                .body("lastName", hasItem("Ash"));
    }

    // DELETE request deletes an object.
    @Test(priority = 4, description = "Remove an employee: DELETE practice.")
    public void removeEmployee() {
        System.out.println("Before: ");
        getAllEmployees();

        RequestSpecification request = RestAssured.given();
        request.header("Content-Type", "application/json");

        Response response = request.delete(localURI + 4);
        Assert.assertEquals(response.statusCode(), 200);

        System.out.println("After: ");
        response = getAllEmployees();
        // We can check for NON-existence by negating the result of hasItem()
        // In other words: since we've deleted an object with the id 4
        // using the method hasItem() will return false. Then by calling not() on the result
        // we get a result of true for the question "has the employee with id: 4 been deleted?"
        response.then()
                .assertThat()
                .body("firstName", not(hasItem("Johnny")));
    }

    public JsonObject generateJsonObject(int id, String firstName, String lastName, String email, String phoneNumber) {
        JsonObject requestParams = new JsonObject();
        requestParams.addProperty("employeeId", id);
        requestParams.addProperty("firstName", firstName);
        requestParams.addProperty("lastName", lastName);
        requestParams.addProperty("email", email);
        requestParams.addProperty("phone", phoneNumber);

        return requestParams;
    }

    // PUT requires you to give the entire object as the payload.
    @Test(priority = 5, description = "Updates an employee: PUT practice.")
    public void updateEmployeeWithPut() {
        System.out.println("Before: ");
        getAllEmployees();

        // Generate the JsonObject with the information that should be saved.
        JsonObject requestParams = generateJsonObject(1, "Johnny", "Ash", "jash@gmail.com", "818-555-5525");

        RequestSpecification request = RestAssured.given();
        // Add a header stating the Request body is a JSON
        request.header("Content-Type", "application/json");
        // Add the Json to the body of the request
        request.body(requestParams.getAsJsonObject());

        // Post the request and check the response
        Response response = request.put(localURI + 1);
        Assert.assertEquals(response.statusCode(), 200);

        System.out.println("After: ");
        getAllEmployees().then()
                .assertThat()
                .body("firstName[0]", equalTo("Johnny"));
    }

    @Test(priority = 6, description = "Restore an employee to before values: PUT practice.")
    public void restoreEmployeeWithPut() {
        System.out.println("Before: ");
        getAllEmployees();

        // Generate the JsonObject with the information that should be saved.
        JsonObject requestParams = generateJsonObject(1, "John", "Doe", "john@doe.com", "555-1212");

        RequestSpecification request = RestAssured.given();
        // Add a header stating the Request body is a JSON
        request.header("Content-Type", "application/json");
        // Add the Json to the body of the request
        request.body(requestParams.getAsJsonObject());

        // Post the request and check the response
        Response response = request.put(localURI + 1);
        Assert.assertEquals(response.statusCode(), 200);

        System.out.println("After: ");
        getAllEmployees().then()
                .assertThat()
                .body("firstName[0]", equalTo("John"));
    }

    // PATCH only requires the part of the object that needs to be updated in the payload.
    // This means you don't need to provide all the variables but rather only the variable you want to change.
    // Example: With PUT you need to provide int id, String firstName, String lastName, String email, String phoneNumber
    // But with PATCH you only need to provide firstName or email
    @Test(priority = 7, description = "Updates an employee: PATCH practice")
    public void updateEmployeeWithPatch() {
        System.out.println("Before: ");
        getAllEmployees();

        // Generate the JsonObject with the information that should be saved.
        JsonObject requestParams = new JsonObject();
        requestParams.addProperty("firstName", "Johnny");

        RequestSpecification request = RestAssured.given();
        // Add a header stating the Request body is a JSON
        request.header("Content-Type", "application/json");
        // Add the Json to the body of the request
        request.body(requestParams.getAsJsonObject());

        // Post the request and check the response
        Response response = request.patch(localURI + 1);

        response.prettyPrint();
        Assert.assertEquals(response.statusCode(), 200);

        System.out.println("After: ");
        getAllEmployees().then()
                .assertThat()
                .body("firstName[0]", equalTo("Johnny"));
    }

    @Test(priority = 8, description = "Updates an employee: PATCH practice")
    public void restoreEmployeeWithPatch() {
        System.out.println("Before: ");
        getAllEmployees();

        // Generate the JsonObject with the information that should be saved.
        JsonObject requestParams = new JsonObject();
        requestParams.addProperty("firstName", "John");

        RequestSpecification request = RestAssured.given();
        // Add a header stating the Request body is a JSON
        request.header("Content-Type", "application/json");
        // Add the Json to the body of the request
        request.body(requestParams.getAsJsonObject());

        // Post the request and check the response
        Response response = request.patch(localURI + 1);

        response.prettyPrint();
        Assert.assertEquals(response.statusCode(), 200);

        System.out.println("After: ");
        getAllEmployees().then()
                .assertThat()
                .body("firstName[0]", equalTo("John"));
    }
}