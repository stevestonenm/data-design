<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Persona</h1>
			<p><strong>Name:</strong>Wahyudi<br>
				<strong>Age:</strong>42<br></p>
			<p><strong>Profession:</strong> Artist from Indonesia who has a desire to share his art
				with the rest of the world. He specialty is wooden figures of animals from Asia: elephants,
				tigers, pandas, etc. These range in size from small palm sized carvings to real life sized carvings. He has
				made a good living in Indonesia and is hoping by expanding into an onlinemmarketplace he can generate
				additional income for his family.</p>
			<p><strong>Technology:</strong>Basic Windows user. He has a Dell laptop, an iPhone 6 and no other hardware.
				He uses his laptop for basic web surfing and connecting with friends on Facebook. He uploads photos from his
				phone to his computer as well as posting photos straight from his phone to Facebook. He believes that he has
				the skill set necessary to use Etsy.</p>
			<p><strong>Attitudes and Behaviors:</strong>Spends most of his time working on his craft as everything he makes
				is from raw materials. He does do a small amount of online shopping but that is mostly for the tools he
				needs if they are not available locally. Most of his art is sold at a local open air market but he does
				supply a few small shops around his country.</p>
			<p><strong>Needs:</strong>Wahyudi needs to be able to get more people to simply see his art. He is very well
				known in his local area for being <em>the best</em> at what he does.  He believes if he can simply get more
				people to see his work he can increase his income. An online market place for handmade products is exactly
				where he wants to offer up his craft for sale.</p>
			<p><strong>Goals:</strong> At this point Wahyudi is able to create his carvings much
				faster than he is selling them. This should allow him to offer many different items online and still keep
				up with demand. He would like to push his production capabilities to see what is his max production can be.</p>
			<p><strong>User Story:</strong>Wahyudi needs to be able to quickly list his items so he can get multiple
				listings up in a short amount of time.</p>
		<h1>Use Case</h1>
			<p>Wahyudi, over the last week, has finished multiple new carvings. He has had them up at his stall in his local
				open air marketplace but foot traffic has been really light. Unfortunately he has only been able to sell one
				of his new pieces and none of the stores he supplies has any space for his new work. This is the perfect
				example of why he wants to put his art up on Etsy.</p>
			<p>On Monday, Wahyudi his hoping to get Etsy set up so he can start posting his carvings to the world. By using
				his phone to take pictures and his desktop to complete the other tasks he is confident he will soon be
				selling to the world.</p>
		<h1>Interaction Flow</h1>
			<ol>
				<li>Put in username</li>
				<li>Enter password</li>
				<li>Click sign in</li>
				<li>Add photos from from local drive</li>
				<li>Set up listing details
					<ol type="a">
						<li>Decide on a title for your item</li>
						<li>Write item description</li>
						<li>Determine Item type: Physical Item/Digital Item</li>
						<li>List type of materials used</li>
						<li>Add tags to listing</li>
					</ol>
				</li>
				<li>List Inventory</li>
				<li>Set Up Prices</li>
				<li>List Shipping Costs</li>
				<li>List Processing Time</li>
				<li>List Policies</li>
			</ol>
		<h1>Conceptual Model</h1>
		<h3>Entities and Attributes</h3>
		<h4>Seller</h4>
			<ul>
				<li>sellerId(primaryKey)</li>
				<li>sellerEmail</li>
				<li>sellerHash</li>
				<li>sellerSalt</li>
			</ul>
		<h4>Item</h4>
		<ul>
			<li>itemId(primaryKey)</li>
			<li>itemSellerId(foreignKey)</li>
			<li>itemName</li>
			<li>itemDescription</li>
			<li>itemLocation</li>
			<li>itemMaterials</li>
		</ul>
		<h4>Image</h4>
			<ul>
				<li>imageId(primaryKey)</li>
				<li>imageItemId(foreignKey)</li>
				<li>imageName</li>
				<li>imageType</li>
			</ul>
		<h3>Relations</h3>
			<ul>
				<li>One seller can sell many items-1 to n)</li>
				<li>One item can have many images-(1 to n)</li>
			</ul>
		<img src="images/erd.jpg" alt="data design erd">
	</body>
</html>