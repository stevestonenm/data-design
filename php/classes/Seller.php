<?php

namespace Edu\Cnm\DataDesign;


/**
 *Typical Profile for an eCommerce site
 *
 * Profile is an abbreviated example of data collected and stored about a user for eCommerce. This example can be
 * extended to include more information such as address, phone number, etc.
 *
 * @author Steve Stone <stoneflynm@gmail.com>
 * @version 1.0.0
 **/
class Seller {
	/**
	 * id for this Seller; this is the primary key
	 * @var int $sellerId
	 **/
	private $sellerId;

	/**
	 * email for this person
	 * @var string $sellerEmail
	 **/
	private $sellerEmail;

	/**
	 * hash for seller password
	 * @var $sellerHash
	 **/
	private $sellerHash;

	/**
	 * salt for seller password
	 * @var $sellerSalt
	 **/
	private $sellerSalt;

	/**
	 * constructor for this seller
	 *
	 * @param int|null $newSellerId id of this seller or null if a new seller
	 * @param string $newSellerEmail string containing the email
	 * @param string $newSellerHash string containing password hash
	 * @param string $newSellerSalt string containing password salt
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(?int $newSellerId, string $newSellerEmail, string $newSellerHash, string $newSellerSalt) {
		try {
			$this->setSellerId($newSellerId);
			$this->setSellerEmail($newSellerEmail);
			$this->setSellerHash($newSellerHash);
			$this->setSellerSalt($newSellerSalt);
		}
		//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for seller id
	 *
	 * @return int|null value of seller id
	 **/
	public function getSellerId(): int {
		return ($this->sellerId);
	}

	/**
	 * mutator method for seller id
	 *
	 * @param int|null $newSellerId new value of seller id
	 * @throws \RangeException if $newSellerId is not positive
	 * @throws \TypeError if $newSellerId is not an integer
	 **/
	public function setSellerId(?int $newSellerId): void {
		if($newSellerId === null) {
			$this->sellerId = null;
			return;
		}

		// verify the seller id is positive
		if($newSellerId <= 0) {
			throw(new \RangeException("seller id is not positive"));
		}

		//convert and store the seller id
		$this->sellerId = $newSellerId;
	}

	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 */
	public function getSellerEmail(): string {
		return $this->sellerEmail;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newSellerEmail new value of email
	 * @throws \InvalidArgumentException $newSellerEmail is not a valid email or insecure
	 * @throws \RangeException if $newSellerEmail is > 128 characters
	 * @throws \TypeError if $newSellerEmail is not a string
	 */
	public function setSellerEmail(string $newSellerEmail): void {
		// verify the email is secure
		$newSellerEmail = trim($newSellerEmail);
		$newSellerEmail = filter_var($newSellerEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newSellerEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}
		//verify the email will fit in the database
		if(strlen($newSellerEmail) > 128) {
			throw(new \RangeException("profile email is too large"));
		}
		// store the email
		$this->sellerEmail = $newSellerEmail;
	}

	/**
	 * accesor method for sellerHash
	 *
	 * @return string value hash
	 */
	public function getSellerHash(): string {
		return $this->sellerHash;
	}

	/**mutator method for seller hash password
	 *
	 * @param string $newSellerHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters long
	 * @throws   \TypeError if seller hash is not a string
	 * */
	public function setSellerHash(string $newSellerHash): void {
		//enforce that the hash is properly formatted
		$newSellerHash = trim($newSellerHash);
		$newSellerHash = strtolower($newSellerHash);
		if(empty($newSellerHash) === true) {
			throw(new \InvalidArgumentException("seller password hash empty or insecure"));
		}
		//enforce that the hash is a sting representation of a hexadecimal
		if(!ctype_xdigit($newSellerHash)) {
			throw(new \InvalidArgumentException("profile hash is empty or insecure"));
		}

		//enforce that the hash is exactly 128 characters
		if(strlen($newSellerHash) !== 128) {
			throw(new \RangeException("profile hash must be 128 characters"));
		}

		//store the hash
		$this->sellerHash = $newSellerHash;
	}

	/**
	 * accessor method for seller salt
	 *
	 * @return string representation of the salt hexadecimal
	 */
	public function getSellerSalt(): string {
		return $this->sellerSalt;
	}

	/**
	 * mutator method for seller salt
	 *
	 * @param string $newSellerSalt
	 * @throws \InvalidArgumentException if seller salt is not secure
	 * @throws \RangeException if the seller salt is not 64 characters
	 * @throws \TypeError if seller salt is not a string
	 */
	public function setSellerSalt(string $newSellerSalt): void {
		//enforce that the salt is properly formatted
		$newSellerSalt = trim($newSellerSalt);
		$newSellerSalt = strtolower($newSellerSalt);

		//enforce that the salt is a string representation of a hexadecimal
		if(!ctype_xdigit($newSellerSalt)) {
			throw(new \InvalidArgumentException("seller password salt is empty or insecure"));
		}

		//enforce that the salt is exactly 64 characters
		if(strlen($newSellerSalt) !== 64) {
			throw(new \RangeException("seller salt must be 64 characters"));
		}

		// store the salt
		$this->sellerSalt = $newSellerSalt;
	}

	/**
	 * inserts this seller into mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is is not a PDO connection object
	 */
	public function insert(\PDO $pdo): void {
		// enforce the sellerId is null (i.e., don't insert a profile that already exists)
		if($this->sellerId !== null) {
			throw(new \PDOException("not a new seller"));
		}
		// create query template
		$query = "INSERT INTO seller(sellerEmail, sellerHash, sellerSalt) VALUES (:sellerEmail, :sellerHash, :sellerSalt)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["sellerEmail" => $this->sellerEmail, "sellerHash" => $this->sellerHash, "sellerSalt" => $this->sellerSalt];
		$statement->execute($parameters);

		//update the null sellerId with what mySQL just gave us
		$this->sellerId = intval($pdo->lastInsertId());
	}
	/**
	 * deletes this seller from mysql
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void{
		// enforce the sellerId is not null (i.e., don't delete a seller that does not exist)
		if($this->sellerId === null) {
			throw(new \PDOException("unable to delete a seller that does not exist"));
		}

		//create query template
		$query = "DELETE FROM seller WHERE sellerId = :sellerId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["sellerId" => $this->sellerId];
		$statement->execute($parameters);
	}

	/**
	 * updates this seller from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {
		// enforce the sellerId is not null (i.e. don't update a profile that does not exist)
		if($this->sellerId === null) {
			throw(new \PDOException("unable to update a seller that does not exist"));
		}
		// create query template
		$query = "UPDATE seller SET sellerEmail = :sellerEmail, sellerHash = :sellerHash, sellerSalt = :sellerSalt WHERE sellerId = :sellerId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["sellerId" => $this->sellerId, "sellerEmail" => $this->sellerEmail, "sellerHash" => $this->sellerHash, "sellerSalt" => $this->sellerSalt];
		$statement->execute($parameters);
	}

	/**
	 * gets the seller by seller id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $sellerId seller id to search for
	 * @return Seller|null Seller or null if not found
	 * throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getSellerBySellerId(\PDO $pdo, int $sellerId):?Seller {
		// sanitize the seller id before searching
		if($sellerId <= 0){
			throw(new \PDOException("profile id is not positive"));
		}

		//create query template
		$query = "SELECT sellerId, sellerEmail, sellerHash, sellerSalt FROM seller WHERE sellerId = :sellerId";
		$statement = $pdo->prepare($query);

		// bind the seller id to the place holder in the template
		$parameters = ["sellerId" => $sellerId];
		$statement->execute($parameters);

		// grab the seller from mySQL
		try{
				$seller = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
							$seller = new Seller($row["sellerId"], $row["sellerEmail"], $row["sellerHash"], $row["sellerSalt"]);
				}
		} catch(\Exception $exception){
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($seller);
	}
}


