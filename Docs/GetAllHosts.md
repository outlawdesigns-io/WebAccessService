**Get All Hosts**
----
  Returns json array of all Hosts.

* **URL**

  /host/

* **Method:**

  `GET`

*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:**
    ```
    [
      {
	    "id": "10",
	    "label": "api.outlawdesigns.io",
	    "friendlyLabel": "Web Access Service",
	    "port": "9500",
	    "log_path": "/var/log/apache2/default.access.log"
      },
      ....]
    ```

* **Error Response:**

  * **Code:** 200 <br />
    **Content:** `{ error : "Access Denied. No Token Present." }`

    OR

    * **Code:** 200 <br />
      **Content:** `{ error : "Access Denied. Invalid Token." }`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/host/",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
