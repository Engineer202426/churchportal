<?php
ob_start();
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  header("Location: ./login.php");
  exit;
}


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["videoFile"])) {
      $uploadDir = 'uploaded_videos/';
      $uploadFile = $uploadDir . basename($_FILES['videoFile']['name']);
      if (move_uploaded_file($_FILES['videoFile']['tmp_name'], $uploadFile)) {
        echo '<script>alert("File uploaded successfully.");</script>';
      } else {
        echo '<script>alert("Error uploading file.");</script>';
      }
    }
    $directory = './uploaded_videos/';
    $videos = array_diff(scandir($directory), array('..', '.'));

ob_end_flush();




$contentFile = "content.txt"; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Guest</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
</head>

<body>
  <?php include 'navbar.php'; ?>

  <div class="container">
    <h1>Welcome Brother and Sister</h1>




    <div class="row">
      <div class="col-sm-1">
      <button class="btn btn-primary btn-lg btn-block" onclick="scrollToBeliefs()">Doctrine</button>
      </div>
      <div class="col-sm-1">
        <a href="guestlearningA.php" class="btn btn-primary btn-lg btn-block">Learning</a>
      </div>
      
    </div>
    <h1>Enter with Hope, Leave with Faith: Welcome to Our Church Family</h1>
    <div class="row">
  <div class="col-md-7">
    <button id="editButton" class="btn btn-primary">Edit</button>
    <button id="saveButton" class="btn btn-primary" style="display:none;">Save</button>
    <div class="book-page">
      <div id="content">
        <?php
        $contentFilePath = "./components/$contentFile";
        if (file_exists($contentFilePath)) {
          $content = file_get_contents($contentFilePath);
          echo "<p id='textContent'>$content</p>";
        } else {
          echo "<p>No content available for this book.</p>";
        }
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-5">
      <div class="text-center">
        <img src="./components/hand.jpg" alt="Description of the image" style="max-width: 100%; height: auto;margin-top: 50px;">
      </div>
      <div class="mt-3">
        <div class="cardboard">
          <p>Seventh-day Adventists accept the Bible as their only creed and hold certain fundamental beliefs to be the teaching of the Holy Scriptures. These beliefs, as set forth here, constitute the church’s understanding and expression of the teaching of Scripture. Revision of these statements may be expected at a General Conference Session when the church is led by the Holy Spirit to a fuller understanding of Bible truth or finds better language in which to express the teachings of God’s Holy Word.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
<div class="col-md-7">
<video id="firstVideo" src="./uploaded_videos/<?php echo $videos[2]; ?>" controls autoplay width="700" height="500">
  Your browser does not support the video tag.
</video>
</div>
  
  <div class="col-md-5" >
      <div class="text-center">
        <img src="./components/bible.jpg" alt="Description of the image" style="max-width: 500px; height: 300px;margin-top: 150px;">
      </div>
      <div class="mt-3">
        <div class="cardboard">
          <p>As Seventh-day Adventists, our promise is to help our friends understand the Bible to find freedom, healing and hope in Jesus. If you would like to experience this kind of relationship with Jesus and learn more about His plans for you, we’ve selected a variety of Bible studies to get you started.</p>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Custom Modal -->
<div id="videoModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Select Video to Play</h2>
    <div class="row">
      <?php
        // Path to the directory
        $directory = './uploaded_videos/';
        
        // Scan the directory and list the video files
        $videos = scandir($directory);
        foreach ($videos as $video) {
          if ($video !== '.' && $video !== '..') {
            // Display video thumbnail
            echo '<div class="col-sm-2 mb-3">';
            echo '<video src="./uploaded_videos/' . $video . '" class="img-thumbnail" onclick="playSelectedVideo(\'' . $video . '\')" style="cursor:pointer;width:50px;height:50px;"></video>';
            echo '</div>';
          }
        }
      ?>
    </div>
    
    <button class="btn btn-primary" onclick="closeModal()">Cancel</button>
  </div>
</div>
    <!-- Modal Button -->
    <button type="button" class="btn btn-primary m-5" onclick="openModal()">
      Select Video to Play
    </button>
    <!-- Upload Button Modal -->
    <button type="button" class="btn btn-primary" onclick="openUploadModal()">
      Upload Videos
    </button>
  
  <!-- Upload Modal -->
<div id="uploadModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeUploadModal()">&times;</span>
    <h2 class="mb-3">Upload Videos</h2>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="videoFile" class="form-label">Select Video File</label>
        <input type="file" class="form-control" id="videoFile" name="videoFile">
      </div>
      <button type="submit" class="btn btn-primary">Upload</button>
    </form>
  </div>
</div>

<div id="fundamentalBeliefs" style="padding-top: 50px;">
    <div class="container">
      <h1>28 Fundamental Beliefs</h1>



<div class="text-center">
        <img src="./components/god.jpg" alt="Description of the image" style="max-width: 500px; height: 300px;margin-top: 40px;margin-right: 900px;">
      </div>
      <div class="mt-3">
        <div class="cardboard">
        <p style="font-size: 24px; font-weight: bold;">GOD</p>
          <p>Our Creator God is love, power and splendor. He is three-in-one, mysterious and infinite—yet He desires an intimate connection with humanity. He gave us the Bible as His Holy Word, so we could learn more about Him and build a relationship with Him.  
          The following statements describe what the Seventh-day Adventist Church believes about God and His Word.</p>
        </div>
        <p style="font-weight: bold;">1. Holy Scriptures</p>
        <div class="cardboard">
        The Holy Scriptures, Old and New Testaments, are the written Word of God, given by divine inspiration. 
        The inspired authors spoke and wrote as they were moved by the Holy Spirit. In this Word, God has committed to humanity the knowledge necessary for salvation. 
        The Holy Scriptures are the supreme, authoritative, and the infallible revelation of His will. They are the standard of character, the test of experience, the definitive revealer of doctrines, and the trustworthy record of God’s acts in history. 
        (Ps. 119:105; Prov. 30:5, 6; Isa. 8:20; John 17:17; 1 Thess. 2:13; 2 Tim. 3:16, 17; Heb. 4:12; 2 Peter 1:20, 21.)
        </div>
      </div>
      <p style="font-weight: bold;">2. The Trinity</p>
        <div class="cardboard">
        There is one God: Father, Son, and Holy Spirit, a unity of three coeternal Persons. 

God is immortal, all-powerful, all-knowing, above all, and ever present. He is infinite and beyond human comprehension, yet known through His self-revelation. 

God, who is love, is forever worthy of worship, adoration, and service by the whole creation. 

(Gen. 1:26; Deut. 6:4; Isa. 6:8; Matt. 28:19; John 3:16; 2 Cor. 1:21, 22; 13:14; Eph. 4:4-6; 1 Peter 1:2.)
      </div>
   

      <p style="font-weight: bold;">3. God the Father</p>
        <div class="cardboard">
        God the eternal Father is the Creator, Source, Sustainer, and Sovereign of all creation. He is just and holy, merciful and gracious, slow to anger, and abounding in steadfast love and faithfulness. 

The qualities and powers exhibited in the Son and the Holy Spirit are also those of the Father. 

(Gen. 1:1; Deut. 4:35; Ps. 110:1, 4; John 3:16; 14:9; 1 Cor. 15:28; 1 Tim. 1:17; 1 John 4:8; Rev. 4:11.)
   
</div>
<img src="./components/cross.jpg" alt="Description of the image" style="max-width: 500px; height: 300px;margin-top: 40px;margin-right: 900px;">

<p style="font-weight: bold;">4. God the Son (Jesus Christ)</p>
        <div class="cardboard">
        God the eternal Son became incarnate in Jesus Christ. Through Him all things were created, the character of God is revealed, the salvation of humanity is accomplished, and the world is judged. 

Forever truly God, He became also truly human, Jesus the Christ. He was conceived of the Holy Spirit and born of the virgin Mary. He lived and experienced temptation as a human being, but perfectly exemplified the righteousness and love of God. 

By His miracles He manifested God’s power and was attested as God’s promised Messiah. He suffered and died voluntarily on the cross for our sins and in our place, was raised from the dead, and ascended to heaven to minister in the heavenly sanctuary on our behalf. 

He will come again in glory for the final deliverance of His people and the restoration of all things. 

(Isa. 53:4-6; Dan. 9:25-27; Luke 1:35; John 1:1-3, 14; 5:22; 10:30; 14:1–3, 9, 13; Rom. 6:23; 1 Cor. 15:3, 4; 2 Cor. 3:18; 5:17-19; Phil. 2:5–11; Col. 1:15-19; Heb. 2:9-18; 8:1, 2.)
</div>
<p style="font-weight: bold;">5. God the Holy Spirit</p>
        <div class="cardboard">
        God the eternal Spirit was active with the Father and the Son in Creation, incarnation, and redemption. 

He is as much a person as are the Father and the Son. He inspired the writers of Scripture. He filled Christ’s life with power. He draws and convicts human beings; and those who respond He renews and transforms into the image of God. 

Sent by the Father and the Son to be always with His children, He extends spiritual gifts to the church, empowers it to bear witness to Christ, and in harmony with the Scriptures leads it into all truth. 

(Gen. 1:1, 2; 2 Sam. 23:2; Ps. 51:11; Isa. 61:1; Luke 1:35; 4:18; John 14:16-18, 26; 15:26; 16:7-13; Acts 1:8; 5:3; 10:38; Rom. 5:5; 1 Cor. 12:7-11; 2 Cor. 3:18; 2 Peter 1:21.)
</div>

<img src="./components/hum.jpg" alt="Description of the image" style="max-width: 500px; height: 300px;margin-top: 40px;margin-right: 900px;">

<p style="font-weight: bold;">HUMANITY</p>
     
<p>Lovingly designed as perfect beings, God created humans in His own image with free will and dominion over the earth. But sin crept in through temptation by Satan, the Devil. Now humanity’s perfection is tarnished, our bodies and minds corrupted. Our once-idyllic world continues to be in a constant struggle between good and evil.

Fortunately, God had a plan to redeem humanity through His Son, Jesus Christ. He will ultimately have victory over sin and death and restore us and our earth to its original state of beauty and perfection.

The following statements describe what the Seventh-day Adventist Church believes about the earth and humanity in the context of God’s ultimate plan.</p>
<p style="font-weight: bold;">6. Creation</p>
        <div class="cardboard">
        God has revealed in Scripture the authentic and historical account of His creative activity. He created the universe, and in a recent six-day creation the Lord made “the heavens and the earth, the sea, and all that is in them” and rested on the seventh day. 

Thus He established the Sabbath as a perpetual memorial of the work He performed and completed during six literal days that together with the Sabbath constituted the same unit of time that we call a week today. 

The first man and woman were made in the image of God as the crowning work of Creation, given dominion over the world, and charged with responsibility to care for it. When the world was finished it was “very good,” declaring the glory of God. 

(Gen. 1-2; 5; 11; Exod. 20:8-11; Ps. 19:1–6; 33:6, 9; 104; Isa. 45:12, 18; Acts 17:24; Col. 1:16; Heb. 1:2; 11:3; Rev. 10:6; 14:7.)
</div>
<p style="font-weight: bold;">7. Nature of Humanity</p>
        <div class="cardboard">
        Man and woman were made in the image of God with individuality, the power and freedom to think and to do. Though created free beings, each is an indivisible unity of body, mind, and spirit, dependent upon God for life and breath and all else. 

When our first parents disobeyed God, they denied their dependence upon Him and fell from their high position. The image of God in them was marred and they became subject to death. 

Their descendants share this fallen nature and its consequences. They are born with weaknesses and tendencies to evil. But God in Christ reconciled the world to Himself and by His Spirit restores in penitent mortals the image of their Maker. Created for the glory of God, they are called to love Him and one another, and to care for their environment. 

(Gen. 1:26-28; 2:7, 15; 3; Ps. 8:4-8; 51:5, 10; 58:3; Jer. 17:9; Acts 17:24-28; Rom. 5:12-17; 2 Cor. 5:19,  20; Eph. 2:3; 1 Thess. 5:23; 1 John 3:4; 4:7, 8, 11, 20.)

</div>


<img src="./components/sal.jpg" alt="Description of the image" style="max-width: 500px; height: 300px;margin-top: 40px;margin-right: 900px;">

<p style="font-weight: bold;">SALVATION</p>
     
<p>Even before the creation of the earth, there was war between good and evil. Lucifer, a once-perfect and highly-regarded being, became jealous of God and wished for higher position. When God did not give him what he wanted, He became Satan. He accused God of being unfair.

Satan then led astray one-third of heaven’s angels, and God had to cast them out. To seek revenge on God, Satan began attacking His precious new creation—the earth. Knowing that humans were created with free will, He tempted them to rebel against God’s loving guidance. 

But God knew this didn’t have to be the end of humanity’s story. He demonstrated just how much He loves us by sending His own Son, Jesus Christ, to die in humanity’s place, to bear the ultimate punishment sin brings (Romans 6:23, John 3:16). 

However, it still comes down to choice. God never wanted forced allegiance. The option is ours. We can succumb to sin and choose to live for ourselves, or we can choose to accept Jesus’ sacrifice, follow Him, and get to know Him. And if we choose Him, He promises to guide us with His Holy Spirit and will never forsake us. 

The following statements describe what the Seventh-day Adventist Church believes about the struggle between good and evil, and how there is still hope for humanity’s salvation through the loving sacrifice of Jesus Christ.
<p style="font-weight: bold;">8. The Great Controversy</p>
        <div class="cardboard">
        All humanity is now involved in a great controversy between Christ and Satan regarding the character of God, His law, and His sovereignty over the universe. 

This conflict originated in heaven when a created being, endowed with freedom of choice, in self-exaltation became Satan, God’s adversary, and led into rebellion a portion of the angels. He introduced the spirit of rebellion into this world when he led Adam and Eve into sin.

This human sin resulted in the distortion of the image of God in humanity, the disordering of the created world, and its eventual devastation at the time of the global flood, as presented in the historical account of Genesis 1-11. 

Observed by the whole creation, this world became the arena of the universal conflict, out of which the God of love will ultimately be vindicated. To assist His people in this controversy, Christ sends the Holy Spirit and the loyal angels to guide, protect, and sustain them in the way of salvation. 

(Gen. 3; 6-8; Job 1:6-12; Isa. 14:12-14; Ezek. 28:12-18; Rom. 1:19-32; 3:4; 5:12-21; 8:19-22; 1 Cor. 4:9; Heb. 1:14; 1 Peter 5:8; 2 Peter 3:6; Rev. 12:4-9.)

</div>
<img src="./components/cr.jpg" alt="Description of the image" style="max-width: 500px; height: 300px;margin-top: 40px;margin-right: 900px;">
<p style="font-weight: bold;">9. The Life, Death and Resurrection of Christ</p>
        <div class="cardboard">
        In Christ’s life of perfect obedience to God’s will, His suffering, death, and resurrection, God provided the only means of atonement for human sin, so that those who by faith accept this atonement may have eternal life, and the whole creation may better understand the infinite and holy love of the Creator. 

This perfect atonement vindicates the righteousness of God’s law and the graciousness of His character; for it both condemns our sin and provides for our forgiveness.

The death of Christ is substitutionary and expiatory, reconciling and transforming. The bodily resurrection of Christ proclaims God’s triumph over the forces of evil, and for those who accept the atonement, assures their final victory over sin and death. It declares the Lordship of Jesus Christ, before whom every knee in heaven and on earth will bow. 

(Gen. 3:15; Ps. 22:1; Isa. 53; John 3:16; 14:30; Rom. 1:4; 3:25; 4:25; 8:3, 4; 1 Cor. 15:3, 4, 20-22; 2 Cor. 5:14, 15, 19-21; Phil. 2:6-11; Col. 2:15; 1 Peter 2:21, 22; 1 John 2:2; 4:10.)
</div>
<p style="font-weight: bold;">10. The Experience of Salvation</p>
        <div class="cardboard">
        In infinite love and mercy God made Christ, who knew no sin, to be sin for us, so that in Him we might be made the righteousness of God. 

Led by the Holy Spirit we sense our need, acknowledge our sinfulness, repent of our transgressions, and exercise faith in Jesus as Saviour and Lord, Substitute and Example. This saving faith comes through the divine power of the Word and is the gift of God’s grace.

Through Christ we are justified, adopted as God’s sons and daughters, and delivered from the lordship of sin. Through the Spirit we are born again and sanctified; the Spirit renews our minds, writes God’s law of love in our hearts, and we are given the power to live a holy life. 

Abiding in Him we become partakers of the divine nature and have the assurance of salvation now and in the judgment. 

(Gen. 3:15; Isa. 45:22; 53; Jer. 31:31-34; Ezek. 33:11; 36:25-27; Hab. 2:4; Mark 9:23, 24; John 3:3-8, 16; 16:8; Rom. 3:21-26; 8:1-4, 14-17; 5:6-10; 10:17; 12:2; 2 Cor. 5:17-21; Gal. 1:4; 3:13, 14, 26; 4:4-7; Eph. 2:4-10; Col. 1:13, 14; Titus 3:3-7; Heb. 8:7-12; 1 Peter 1:23; 2:21, 22; 2 Peter 1:3, 4; Rev. 13:8.)
</div>
<img src="./components/cover.jpg" alt="Description of the image" style="max-width: 500px; height: 300px;margin-top: 40px;margin-right: 900px;">
<p style="font-weight: bold;">11. Growing in Christ</p>
        <div class="cardboard">
        By His death on the cross, Jesus triumphed over the forces of evil. He who subjugated the demonic spirits during His earthly ministry has broken their power and made certain their ultimate doom. 

Jesus’ victory gives us victory over the evil forces that still seek to control us, as we walk with Him in peace, joy, and assurance of His love. Now the Holy Spirit dwells within us and empowers us. Continually committed to Jesus as our Saviour and Lord, we are set free from the burden of our past deeds. 

No longer do we live in the darkness, fear of evil powers, ignorance, and meaninglessness of our former way of life. In this new freedom in Jesus, we are called to grow into the likeness of His character, communing with Him daily in prayer, feeding on His Word, meditating on it and on His providence, singing His praises, gathering together for worship, and participating in the mission of the Church. 

We are also called to follow Christ’s example by compassionately ministering to the physical, mental, social, emotional, and spiritual needs of humanity. As we give ourselves in loving service to those around us and in witnessing to His salvation, His constant presence with us through the Spirit transforms every moment and every task into a spiritual experience. 

(1 Chron. 29:11; Ps. 1:1, 2; 23:4; 77:11, 12; Matt. 20:25-28; 25:31-46; Luke 10:17-20; John 20:21; Rom. 8:38, 39; 2 Cor. 3:17, 18; Gal. 5:22-25; Eph. 5:19, 20; 6:12-18; Phil. 3:7-14; Col. 1:13, 14; 2:6, 14, 15; 1 Thess. 5:16-18, 23; Heb. 10:25; James 1:27; 2 Peter 2:9; 3:18; 1 John 4:4.)
</div>
<img src="./components/church.jpg" alt="Description of the image" style="max-width: 500px; height: 300px;margin-top: 40px;margin-right: 900px;">

<p style="font-weight: bold;">CHURCH</p>
     
<p>After Jesus’ ministry on earth, He commissioned His followers to go about their lives telling others about His love and promise to return. In doing this, He also commanded to love all people as He loves all of us. 

As imperfect as humanity is, God still gives us the privilege of being part of His work. In doing this, we are His Church, or the Body of Christ, all with different spiritual gifts to contribute. He encourages us to meet together, support one another, and serve together.

The following statements describe what the Seventh-day Adventist Church believes regarding the fellowship of believers around the world, God’s Great Commission, and the principles to guide organized local congregations. 

<p style="font-weight: bold;">12. The Church</p>
        <div class="cardboard">
        BThe church is the community of believers who confess Jesus Christ as Lord and Saviour. In continuity with the people of God in Old Testament times, we are called out from the world; and we join together for worship, for fellowship, for instruction in the Word, for the celebration of the Lord’s Supper, for service to humanity, and for the worldwide proclamation of the gospel. 

The church derives its authority from Christ, who is the incarnate Word revealed in the Scriptures. The church is God’s family; adopted by Him as children, its members live on the basis of the new covenant. 

The church is the body of Christ, a community of faith of which Christ Himself is the Head. The church is the bride for whom Christ died that He might sanctify and cleanse her. 

At His return in triumph, He will present her to Himself a glorious church, the faithful of all the ages, the purchase of His blood, not having spot or wrinkle, but holy and without blemish. 

(Gen. 12:1-3; Exod. 19:3-7; Matt. 16:13-20; 18:18; 28:19, 20; Acts 2:38-42; 7:38; 1 Cor. 1:2; Eph. 1:22, 23; 2:19-22; 3:8-11; 5:23-27; Col. 1:17, 18; 1 Peter 2:9.)
</div>
<p style="font-weight: bold;">13. The Remnant and its Mission</p>
        <div class="cardboard">
        The universal church is composed of all who truly believe in Christ, but in the last days, a time of widespread apostasy, a remnant has been called out to keep the commandments of God and the faith of Jesus. This remnant announces the arrival of the judgment hour, proclaims salvation through Christ, and heralds the approach of His second advent. 

This proclamation is symbolized by the three angels of Revelation 14; it coincides with the work of judgment in heaven and results in a work of repentance and reform on earth. Every believer is called to have a personal part in this worldwide witness. 

(Dan. 7:9-14; Isa. 1:9; 11:11; Jer. 23:3; Mic. 2:12; 2 Cor. 5:10; 1 Peter 1:16-19; 4:17; 2 Peter 3:10-14; Jude 3, 14; Rev. 12:17; 14:6-12; 18:1-4.)
</div>
<img src="./components/worship.jpg" alt="Description of the image" style="max-width: 500px; height: 300px;margin-top: 40px;margin-right: 900px;">

<p style="font-weight: bold;">14. Unity in the Body of Christ</p>
        <div class="cardboard">
        The church is one body with many members, called from every nation, kindred, tongue, and people. 

In Christ we are a new creation; distinctions of race, culture, learning, and nationality, and differences between high and low, rich and poor, male and female, must not be divisive among us. We are all equal in Christ, who by one Spirit has bonded us into one fellowship with Him and with one another; we are to serve and be served without partiality or reservation. 

Through the revelation of Jesus Christ in the Scriptures we share the same faith and hope, and reach out in one witness to all. This unity has its source in the oneness of the triune God, who has adopted us as His children. 

(Ps. 133:1; Matt. 28:19, 20; John 17:20-23; Acts 17:26, 27; Rom. 12:4, 5; 1 Cor. 12:12-14; 2 Cor. 5:16, 17; Gal. 3:27-29; Eph. 2:13-16; 4:3-6, 11-16; Col. 3:10-15.)
</div>
<p style="font-weight: bold;">15. Baptism</p>
        <div class="cardboard">
        By baptism we confess our faith in the death and resurrection of Jesus Christ, and testify of our death to sin and of our purpose to walk in newness of life. Thus we acknowledge Christ as Lord and Saviour, become His people, and are received as members by His church.
 
 Baptism is a symbol of our union with Christ, the forgiveness of our sins, and our reception of the Holy Spirit. 
 
 It is by immersion in water and is contingent on an affirmation of faith in Jesus and evidence of repentance of sin. It follows instruction in the Holy Scriptures and acceptance of their teachings. 
 
 (Matt. 28:19, 20; Acts 2:38; 16:30-33; 22:16; Rom. 6:1-6; Gal. 3:27; Col. 2:12, 13.)
</div>
<p style="font-weight: bold;">16. The Lord’s Supper (Communion)</p>
        <div class="cardboard">
        The Lord’s Supper is a participation in the emblems of the body and blood of Jesus as an expression of faith in Him, our Lord and Saviour. 

In this experience of communion Christ is present to meet and strengthen His people. As we partake, we joyfully proclaim the Lord’s death until He comes again. 

Preparation for the Supper includes self-examination, repentance, and confession. The Master ordained the service of foot-washing to signify renewed cleansing, to express a willingness to serve one another in Christlike humility, and to unite our hearts in love. 

The communion service is open to all believing Christians. 

(Matt. 26:17-30; John 6:48-63; 13:1-17; 1 Cor. 10:16, 17; 11:23-30; Rev. 3:20.)
</div>

<img src="./components/chr.jpg" alt="Description of the image" style="max-width: 500px; height: 300px;margin-top: 40px;margin-right: 900px;">

<p style="font-weight: bold;">DAILY LIVING</p>
     
<p>All throughout the Bible we can find guidance for our daily lives. A well-known example would be the Ten Commandments in Exodus, where we are shown how to love God and how to love people—which Jesus re-emphasized in the New Testament (Matthew 22:37-40). God’s law shows us the path to follow and the pitfalls to avoid, leading us toward wholeness and balance.

Additionally, by being a Christian and following God, we answer His call to be stewards of the earth until He returns. That also includes taking care of ourselves, caring for our minds and bodies which in turn nourishes our spirit. 

The following statements describe what the Seventh-day Adventist Church believes about what it means to live each day as a follower of Christ.
<p style="font-weight: bold;">17. Spiritual Gifts and Ministries</p>
        <div class="cardboard">
        God bestows upon all members of His church in every age spiritual gifts that each member is to employ in loving ministry for the common good of the church and of humanity. 

Given by the agency of the Holy Spirit, who apportions to each member as He wills, the gifts provide all abilities and ministries needed by the church to fulfill its divinely ordained functions. 

According to the Scriptures, these gifts include such ministries as faith, healing, prophecy, proclamation, teaching, administration, reconciliation, compassion, and self-sacrificing service and charity for the help and encouragement of people. 

Some members are called of God and endowed by the Spirit for functions recognized by the church in pastoral, evangelistic, and teaching ministries particularly needed to equip the members for service, to build up the church to spiritual maturity, and to foster unity of the faith and knowledge of God. 

When members employ these spiritual gifts as faithful stewards of God’s varied grace, the church is protected from the destructive influence of false doctrine, grows with a growth that is from God, and is built up in faith and love. 

(Acts 6:1-7; Rom. 12:4-8; 1 Cor. 12:7-11, 27, 28; Eph. 4:8, 11-16; 1 Tim. 3:1-13; 1 Peter 4:10, 11.)
</div>

<p style="font-weight: bold;">18. The Gift of Prophecy</p>
        <div class="cardboard">
        The Scriptures testify that one of the gifts of the Holy Spirit is prophecy.

This gift is an identifying mark of the remnant church and we believe it was manifested in the ministry of Ellen G. White. Her writings speak with prophetic authority and provide comfort, guidance, instruction, and correction to the church. 

They also make clear that the Bible is the standard by which all teaching and experience must be tested. 

(Num. 12:6; 2 Chron. 20:20; Amos 3:7; Joel 2:28, 29; Acts 2:14-21; 2 Tim. 3:16, 17; Heb. 1:1-3; Rev. 12:17; 19:10; 22:8, 9.)

</div>

<img src="./components/law.jpg" alt="Description of the image" style="max-width: 500px; height: 300px;margin-top: 40px;margin-right: 900px;">

<p style="font-weight: bold;">19. The Law of God</p>
        <div class="cardboard">
        The great principles of God’s law are embodied in the Ten Commandments and exemplified in the life of Christ. They express God’s love, will, and purposes concerning human conduct and relationships and are binding upon all people in every age. 

These precepts are the basis of God’s covenant with His people and the standard in God’s judgment. Through the agency of the Holy Spirit they point out sin and awaken a sense of need for a Saviour. 

Salvation is all of grace and not of works, and its fruit is obedience to the Commandments. 

This obedience develops Christian character and results in a sense of well-being. It is evidence of our love for the Lord and our concern for our fellow human beings. The obedience of faith demonstrates the power of Christ to transform lives, and therefore strengthens Christian witness. 

(Exod. 20:1-17; Deut. 28:1-14; Ps. 19:7-14; 40:7, 8; Matt. 5:17-20; 22:36-40; John 14:15; 15:7-10; Rom. 8:3, 4; Eph. 2:8-10; Heb. 8:8-10; 1 John 2:3; 5:3; Rev. 12:17; 14:12.)
</div>
<p style="font-weight: bold;">15. Baptism</p>
        <div class="cardboard">
        By baptism we confess our faith in the death and resurrection of Jesus Christ, and testify of our death to sin and of our purpose to walk in newness of life. Thus we acknowledge Christ as Lord and Saviour, become His people, and are received as members by His church.
 
 Baptism is a symbol of our union with Christ, the forgiveness of our sins, and our reception of the Holy Spirit. 
 
 It is by immersion in water and is contingent on an affirmation of faith in Jesus and evidence of repentance of sin. It follows instruction in the Holy Scriptures and acceptance of their teachings. 
 
 (Matt. 28:19, 20; Acts 2:38; 16:30-33; 22:16; Rom. 6:1-6; Gal. 3:27; Col. 2:12, 13.)
</div>
<p style="font-weight: bold;">16. The Lord’s Supper (Communion)</p>
        <div class="cardboard">
        The Lord’s Supper is a participation in the emblems of the body and blood of Jesus as an expression of faith in Him, our Lord and Saviour. 

In this experience of communion Christ is present to meet and strengthen His people. As we partake, we joyfully proclaim the Lord’s death until He comes again. 

Preparation for the Supper includes self-examination, repentance, and confession. The Master ordained the service of foot-washing to signify renewed cleansing, to express a willingness to serve one another in Christlike humility, and to unite our hearts in love. 

The communion service is open to all believing Christians. 

(Matt. 26:17-30; John 6:48-63; 13:1-17; 1 Cor. 10:16, 17; 11:23-30; Rev. 3:20.)
</div>









</div>
<script>

function scrollToBeliefs() {
      var beliefsSection = document.getElementById('fundamentalBeliefs');
      beliefsSection.scrollIntoView({ behavior: 'smooth' });
    }
  var videoPlayer; 
  var videos = <?php echo json_encode(array_values($videos)); ?>; 
  var currentIndex = 0; 

  function playNextVideo() {
    currentIndex++;
    if (currentIndex >= videos.length) {
      currentIndex = 0;
    }
    var videoPlayer = document.getElementById("firstVideo");
    videoPlayer.src = "./uploaded_videos/" + videos[currentIndex];
    videoPlayer.play();
  }

  function openModal() {
    var modal = document.getElementById("videoModal");
    modal.style.display = "block";
  }

  function closeModal() {
    var modal = document.getElementById("videoModal");
    modal.style.display = "none";
  }

  function openUploadModal() {
    var modal = document.getElementById("uploadModal");
    modal.style.display = "block";
  }

  function closeUploadModal() {
    var modal = document.getElementById("uploadModal");
    modal.style.display = "none";
  }

  function playSelectedVideo(selectedVideo) {
    videoPlayer = document.getElementById("firstVideo");
    videoPlayer.src = "./uploaded_videos/" + selectedVideo;
    videoPlayer.play();

    
    videoPlayer.onended = function() {
      playNextVideo(); 
    };

    closeModal();
  }

  window.onclick = function(event) {
    var modal = document.getElementById("videoModal");
    if (event.target == modal) {
      modal.style.display = "none";
    }
    var uploadModal = document.getElementById("uploadModal");
    if (event.target == uploadModal) {
      uploadModal.style.display = "none";
    }
  }


  document.getElementById("editButton").addEventListener("click", function() {
  var contentDiv = document.getElementById("content");
  var contentText = document.getElementById("textContent").textContent; 
  var textarea = document.createElement("textarea");
  textarea.id = "editContent";
  textarea.className = "form-control";
  textarea.rows = "5";
  textarea.value = contentText;
  contentDiv.innerHTML = "";
  contentDiv.appendChild(textarea);
  document.getElementById("editButton").style.display = "none";
  document.getElementById("saveButton").style.display = "block";
});


  document.getElementById("saveButton").addEventListener("click", function() {
    var editedContent = document.getElementById("editContent").value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
    
        location.reload();
      }
    };
    xhttp.open("POST", "save_content.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("content=" + editedContent);
  });



  </script>


</body>

</html>
<style>
    body {
      background-image: url('./img/b2.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }


    #videoContainer {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh; 
    }
    #firstVideo {
      margin-top: 100px;
       margin-left: 50px;
    }
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 500px;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.book-page {
  background-color: #F2E8C7; 
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
  padding: 20px;
  margin: 20px 0;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  max-width: 500px;
  font-size: 16px;
  line-height: 1.5;
  color: #000;
  border: 4px solid #2399DA; 
}
.cardboard {
  border: 1px solid #F2E8C7; 
  border-radius: 5px; 
  padding: 15px; 
  max-width: 1000px;
  height: auto;
}

  </style>