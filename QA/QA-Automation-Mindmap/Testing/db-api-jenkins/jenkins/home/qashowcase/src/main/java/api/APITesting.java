package api;

import io.restassured.response.Response;
import org.testng.annotations.Test;
import static io.restassured.RestAssured.*;
import static org.hamcrest.Matchers.*;

public class APITesting {
    @Test
    public void getProduct() {
//        given().header("Content-Type", "application/json")
//                .when().get("http://heatclinic.shiftedtech.com/api/v1/catalog/product/2").prettyPrint();

        given().header("Content-Type", "application/json")
                .when().get("http://heatclinic.shiftedtech.com/api/v1/catalog/product/2")
                .then().statusCode(200)
                .assertThat().body("id", equalTo(2))
                .assertThat().body("primaryMedia.title", equalTo("Sweet Death Sauce Bottle"));

        Response response = given().header("Content-Type", "application/json")
                .when().get("http://heatclinic.shiftedtech.com/api/v1/catalog/product/2");

        response.then().statusCode(200)
                .assertThat().body("name", equalTo("Sweet Death Sauce"));

        response.then().statusCode(200)
                .assertThat().body("primaryMedia.url", equalTo("/cmsstatic/img/sauces/Sweet-Death-Sauce-Bottle.jpg"));

        response.prettyPrint();

        response.then().statusCode(200)
                .assertThat().body("defaultCategoryId", equalTo(2001));
    }
}