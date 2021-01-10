**Search Requests**
----
  Returns json array of Requests matching given search parameters.

* **URL**

  /request/search/:key/:value

* **Method:**

  `GET`

*  **URL Params**

   **Required:**

   `key=[string] -- The field to search on`
   `value=[integer,boolean,string,date] -- The value to search by`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:**
    ```
    [
     {
       "id": "179925",
       "host": "loe.outlawdesigns.io",
       "port": "80",
       "ip_address": "192.168.1.142",
       "platform": "NA",
       "browser": "VLC",
       "version": "3.0.4 LibVLC",
       "responseCode": "416",
       "requestDate": "2019-07-17 12:38:57",
       "requestMethod": "GET",
       "query": "/Video/Movies/31/movie.mp4",
       "referrer": "NA"
      },
    ....]    
    ```

* **Error Response:**

  * **Code:** 200 <br />
    **Content:** `{ error : "Unknown column 'garbage' in 'where clause'" }`

  OR

  * **Code:** 200 <br />
    **Content:** `{ error : "Access Denied. No Token Present." }`

    OR

    * **Code:** 200 <br />
      **Content:** `{ error : "Access Denied. Invalid Token." }`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/request/search/query/.mp4",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
