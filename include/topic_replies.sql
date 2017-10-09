-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 21, 2016 at 05:12 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `topic_replies`
--

CREATE TABLE `topic_replies` (
  `id` int(11) NOT NULL,
  `tid` int(255) NOT NULL,
  `fid` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `content` longtext NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topic_replies`
--

INSERT INTO `topic_replies` (`id`, `tid`, `fid`, `uid`, `content`, `created`, `modified`) VALUES
(5, 16, 67, 2, '<p><span id="sceditor-start-marker" class="sceditor-selection sceditor-ignore" style="line-height: 0; display: none;"> </span>Reply~ &lt;script&gt;alert(''hello'')&lt;/script&gt;<span id="sceditor-end-marker" class="sceditor-selection sceditor-ignore" style="line-height: 0; display: none;"> </span></p>', '2016-12-06 15:46:13', '2016-12-06 07:46:13'),
(6, 23, 57, 2, '<p></p><code><p>function selectCode(a) {</p><p>&nbsp; &nbsp; var y = a.parentNode.getElementsByClassName(''code_content'')[0];</p><p>&nbsp; &nbsp; if (window.getSelection) {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; var i = window.getSelection();</p><p>&nbsp; &nbsp; &nbsp; &nbsp; if(i.setBaseAndExtent) {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; i.setBaseAndExtent(y, 0, y, y.innerText.length - 1)</p><p>&nbsp; &nbsp; &nbsp; &nbsp; } else {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; if(window.opera &amp;&amp; y.innerHTML.substring(y.innerHTML.length - 4) == ''&lt;BR&gt;'') {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; y.innerHTML = y.innerHTML + '' ''</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; }</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; var r = document.createRange();</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; r.selectNodeContents(e);</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; i.removeAllRanges();</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; i.addRange(r)</p><p>&nbsp; &nbsp; &nbsp; &nbsp; }</p><p>&nbsp; &nbsp; } else if(document.getSelection) {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; var i = document.getSelection();</p><p>&nbsp; &nbsp; &nbsp; &nbsp; var r = document.createRange();</p><p>&nbsp; &nbsp; &nbsp; &nbsp; r.selectNodeContents(e);</p><p>&nbsp; &nbsp; &nbsp; &nbsp; i.removeAllRanges();</p><p>&nbsp; &nbsp; &nbsp; &nbsp; i.addRange(r)</p><p>&nbsp; &nbsp; } else if(document.selection) {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; var r = document.body.createTextRange();</p><p>&nbsp; &nbsp; &nbsp; &nbsp; r.moveToElementText(y);</p><p>&nbsp; &nbsp; &nbsp; &nbsp; r.select()</p><p>&nbsp; &nbsp; }</p><p>}</p><p>if(text) {} else {</p><p>&nbsp; &nbsp; var text = ''Selecionar todos''</p><p>}</p><p>$(function () {</p><p><span class="Apple-tab-span" style="white-space:pre">	</span>$("code").wrap(''&lt;dl class="code_content hidecode"&gt;&lt;/dl&gt;'').before(''&lt;dt onclick="selectCode(this)" title="Select all" style="cursor:pointer" style="border: none;"&gt;Select all&lt;/dt&gt;'').wrap(''&lt;dd class="code_content"&gt;&lt;/dd&gt;'');</p><p>&nbsp; &nbsp;$("code").length &amp;&amp; (</p><p>&nbsp; &nbsp; &nbsp; $("code").addClass("prettyprint linenums").parent().prev().attr({</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;onclick: "selectCode(this)",</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;title: "Select all",</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;style: "cursor:pointer"</p><p>&nbsp; &nbsp; &nbsp; })</p><p>&nbsp; &nbsp; );</p><p><span class="Apple-tab-span" style="white-space:pre">	</span>$(''code'').each(function () {</p><p><span class="Apple-tab-span" style="white-space:pre">		</span>$(this).wrap(''&lt;pre class="prettyprint'' + ($(this).text().indexOf("&lt;") == -1 &amp;&amp; /[\\s\\S]+{[\\s\\S]+:[\\s\\S]+}/.test($(this).text()) ? " lang-css" : "") + '' linenums" /&gt;'');</p><p><span class="Apple-tab-span" style="white-space:pre">	</span>});</p><p><span class="Apple-tab-span" style="white-space:pre">	</span>prettyPrint();</p><p>});</p></code><p></p><p class="sceditor-nlf"><br></p>', '2016-12-12 19:57:18', '2016-12-12 11:57:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `topic_replies`
--
ALTER TABLE `topic_replies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `topic_replies`
--
ALTER TABLE `topic_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
