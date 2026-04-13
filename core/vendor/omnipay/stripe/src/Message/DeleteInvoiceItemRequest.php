use it
      // doesn't make sense to ask a sliver for content before its scroll
      // offset.
      final double correctedCacheOrigin = math.max(cacheOrigin, -sliverScrollOffset);
      final double cacheExtentCorrection = cacheOrigin - correctedCacheOrigin;

      assert(sliverScrollOffset >= correctedCacheOrigin.abs());
      assert(correctedCacheOrigin <= 0.0);
      assert(sliverScrollOffset >= 0.0);
      assert(cacheExtentCorrection <= 0.0);

      child.layout(
        SliverConstraints(
          axisDirection: axisDirection,
          growthDirection: growthDirection,
          userScrollDirection: adjustedUserScrollDirection,
          scrollOffset: sliverScrollOffset,
          precedingScrollExtent: precedingScrollExtent,
          overlap: maxPaintOffset - layoutOffset,
          remainingPaintExtent: math.max(
            0.0,
            remainingPaintExtent - layoutOffset + initialLayoutOffset,
          ),
          crossAxisExtent: crossAxisExtent,
          crossAxisDirection: crossAxisDirection,
       