
**Get Request**
----
  Returns json data about a single Request.

* **URL**

  /request/:UID

* **Method:**

  `GET`

*  **URL Params**

   **Required:**

   `UID=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:**
    ```
    {
        "id": "53129",
        "host": "api.outlawdesigns.io",
        "port": "9661",
        "ip_address": "192.168.1.254",
        "platform": "NA",
        "browser": "-",
        "version": "NA",
        "responseCode": "200",
        "requestDate": "2019-03-21 03:02:18",
        "requestMethod": "GET",
        "query": "/verify/",
        "referrer": "NA"
    }
    ```
* **Error Response:**

  * **Code:** 200 <br />
    **Content:** `{ error : "Invalid UID" }`

  OR

  * **Code:** 200 <br />
    **Content:** `{ error : "Access Denied. No Token Present." }`

   OR

    * **Code:** 200 <br />
      **Content:** `{ error : "Access Denied. Invalid Token." }`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/request/53129",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
