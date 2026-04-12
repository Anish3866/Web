<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                    }
                    .header {
                        background-color: #008000;
                        color: #ffffff;
                        text-align: center;
                        padding: 10px;
                        font-size: 24pt;
                        font-weight: bold;
                    }
                    .container {
                        margin: 15px;
                    }
                    .box {
                        border: 1px solid #d3d3d3;
                        margin-bottom: 8px;
                        padding: 15px;
                        text-align: center;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                    }
                    .category-title {
                        color: #008000;
                        text-decoration: underline;
                        font-size: 18pt;
                        font-weight: bold;
                        margin-bottom: 10px;
                        display: block;
                    }
                    .item {
                        display: block;
                        font-size: 10pt;
                        font-weight: bold;
                        margin-top: 3px;
                    }
                    .item-1 { color: #2ecc71; }
                    .item-2 { color: #a93226; }
                    .item-3 { color: #0000ff; }
                    .item-4 { color: #f39c12; }
                </style>
            </head>
            <body>
                <div class="header">
                    <xsl:value-of select="root/header"/>
                </div>
                <div class="container">
                    <xsl:for-each select="root/categories/category">
                        <div class="box">
                            <span class="category-title"><xsl:value-of select="@name"/></span>
                            <xsl:for-each select="item">
                                <xsl:variable name="pos" select="position() mod 4"/>
                                <div class="item">
                                    <xsl:choose>
                                        <xsl:when test="$pos = 1"><xsl:attribute name="class">item item-1</xsl:attribute></xsl:when>
                                        <xsl:when test="$pos = 2"><xsl:attribute name="class">item item-2</xsl:attribute></xsl:when>
                                        <xsl:when test="$pos = 3"><xsl:attribute name="class">item item-3</xsl:attribute></xsl:when>
                                        <xsl:otherwise><xsl:attribute name="class">item item-4</xsl:attribute></xsl:otherwise>
                                    </xsl:choose>
                                    <xsl:value-of select="."/>
                                </div>
                            </xsl:for-each>
                        </div>
                    </xsl:for-each>
                </div>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
