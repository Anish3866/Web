<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

<xsl:output method="xml" indent="yes"/>

<xsl:template match="/">
    <students>
        <xsl:apply-templates select="students/student"/>
    </students>
</xsl:template>

<xsl:template match="student">
    <student reg_no="{reg_no}">
        
        <name>
            <xsl:value-of select="name"/>
        </name>

        <symbol_number>
            <xsl:value-of select="symbol_number"/>
        </symbol_number>

        <marks>
            <subject name="web">
                <xsl:value-of select="marks/web"/>
            </subject>
            <subject name="dsa">
                <xsl:value-of select="marks/dsa"/>
            </subject>
            <subject name="java">
                <xsl:value-of select="marks/java"/>
            </subject>
            <subject name="sad">
                <xsl:value-of select="marks/sad"/>
            </subject>
            <subject name="stat">
                <xsl:value-of select="marks/stat"/>
            </subject>
        </marks>

        <total_marks>
            <xsl:value-of select="marks/web + marks/sad + marks/dsa + marks/java + marks/stat"/>
        </total_marks>

        <percentage>
            <xsl:value-of select="(marks/web + marks/sad + marks/dsa + marks/java + marks/stat) div 5"/>
        </percentage>

    </student>
</xsl:template>

</xsl:stylesheet>