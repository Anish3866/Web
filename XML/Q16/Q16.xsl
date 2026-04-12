<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>

    <xsl:key name="categoryKey" match="product[quantity >= 10]" use="category"/>

    <xsl:template match="/">
        <html>
            <body>
                <h2>Processed Products Catalog</h2>
                <table border="1" cellpadding="5" cellspacing="0">
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    <xsl:for-each select="products/product[quantity >= 10][generate-id() = generate-id(key('categoryKey', category)[1])]">
                        <tr bgcolor="#e6f7ff">
                            <th colspan="5">Category: <xsl:value-of select="category"/></th>
                        </tr>
                        <xsl:for-each select="key('categoryKey', category)">
                            <xsl:sort select="price" data-type="number" order="descending"/>
                            <tr>
                                <td><xsl:value-of select="productname"/></td>
                                <td><xsl:value-of select="category"/></td>
                                <td><xsl:value-of select="price"/></td>
                                <td><xsl:value-of select="quantity"/></td>
                                <td><xsl:value-of select="price * quantity"/></td>
                            </tr>
                        </xsl:for-each>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
