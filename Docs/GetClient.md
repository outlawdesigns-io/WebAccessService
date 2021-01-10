**Get Client**
----
  Returns json data about a single Client.

* **URL**

  /client/:UID

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
	    "Id": "10",
	    "IpAddress": "139.162.119.197",
	    "StreetAddress": "AS63949 Linode, LLC",
	    "City": "Tokyo",
	    "Country": "Japan",
	    "CountryCode": "JP",
	    "Isp": "Linode, LLC",
	    "lat": "35.68820000",
	    "lon": "99.99999999",
	    "Org": "Linode, LLC",
	    "Region": "13",
	    "RegionName": "Tokyo",
	    "TimeZone": "Asia/Tokyo",
	    "Zip": "102",
	    "Malevolent": "0"
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
      url: "/client/10",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
